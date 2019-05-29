<?php

    namespace App\Models\Oracle;

    use Illuminate\Database\Eloquent\Concerns\HasEvents;
    use Illuminate\Database\Eloquent\Model;

    class Claim extends Model
    {
        use HasEvents;

        public $connection = 'oracle';


        public $table = 'SHFRI.VW_GEDO_CLAIMS_DETAILS_FULL';


        protected $hidden = [
            'sch_anl_datum',
            'sch_aen_datum',
            'par_partner_nr',
            'sch_schadenstatus',
            'sqr_quotenposition_nr',
            'sqr_schadenart',
            'sqr_status',
            'gfm_feldmark'
        ];

        protected $appends = ['department_code'];


        public function getDepartmentCodeAttribute()
        {
            if($this->gfm_feldmark) {
                return mb_substr($this->gfm_feldmark, 0, 2);
            }
        }

    }
