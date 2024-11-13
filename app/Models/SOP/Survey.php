<?php

namespace App\Models\SOP;

use App\Models\ACL\User;
use App\Models\BaseModel;
use App\Models\Reference\Classifier;
use Auth;
use Carbon\Carbon;

class Survey extends BaseModel
{
	protected $guarded = [];
	protected $appends = ['available_at','card_message','is_available'];

	public function question_groups()
	{
		return $this->hasMany(QuestionGroup::class);
	}

	public function questions()
	{
		return $this->hasManyThrough(Question::class,QuestionGroup::class);
	}

	public function files()
	{
		return $this->hasMany(SurveyFile::class);
	}

	public function classifiers()
	{
		return $this->belongsToMany(Classifier::class,SurveyClassifier::class,'survey_id','classifier_id')
					->whereNull('survey_classifiers.deleted_at');
	}

	public static function getFrequency($param = null)
	{
		$frequencies = ['routine' => 'Rutin','daily' => 'Harian','weekly' => 'Mingguan','monthly' => 'Bulanan'];
		
		return @$param ? (@$frequencies[$param] ?? null) : $frequencies;
	}

	public function hasReports()
	{
		$reports = SurveyReport::where('survey_id',$this->id)->where('user_id',Auth::user()->id)->first();
		return $reports ? 1 : 0;
	}

	public function latestReportByAuth()
	{
		$report = SurveyReport::where('survey_id',$this->id)
							->where('user_id',Auth::user()->id)
							->orderByDesc('id')
							->first();

		return $report;
	}

	public function getAvailableAtAttribute()
	{
		$availability = SurveyAvailability::where('survey_id',$this->id)
										->where('user_id',Auth::user()->id)
										->first();

		return @$availability->available_at;
	}

	public function getIsAvailableAttribute()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		$available_at = Carbon::parse($this->available_at)->format('Y-m-d H:i:s');
		return ($this->available_at == null || $now >= $available_at) ? 1 : 0;
	}

	public function getAvailableForHumansAttribute()
	{
		$available_at = Carbon::parse($this->available_at);
        $started_at = Carbon::parse($this->started_at);

        return $available_at->diffForHumans($started_at);
	}

	public function getCardMessageAttribute()
	{
		if($this->latestReportByAuth()){
			if($this->latestReportByAuth()->ended_at != null){
				if($this->frequency != 'routine'){
					if($this->is_available == 0){
						return 'Akan tersedia: '.str_replace('setelahnya', 'lagi', $this->available_for_humans);
					}
				}
			}
		}

		return 'Isi Checklist';
	}

	public function unreadUsers()
	{
		return User::leftJoin('jabatan_classifiers','jabatan_classifiers.jabatan_id','users.jabatan_id')
					->leftJoin('survey_reports',function($join){
						$join->on('survey_reports.user_id','=','users.id')
							->where('survey_reports.survey_id',$this->id)
				            ->whereNull('survey_reports.deleted_at');
					})
		            ->when(@$this->classifiers->count() > 0,function($q){
		                return $q->whereIn('classifier_id',$this->classifiers->pluck('id')->toArray());
		            })
		            ->whereNull('survey_reports.id')
		            ->select('users.*')
		            ->with(['jabatan','outlet','kota_link','direktorat','unitBisnis'])
		            ->groupBy('users.id')
		            ->get();
	}
}
