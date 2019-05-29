<?php

    namespace App\Models\Oracle;

    use Illuminate\Database\Eloquent\Concerns\HasEvents;
    use Illuminate\Database\Eloquent\Model;

    class Contract extends Model
    {
        use HasEvents;

        public $connection = 'oracle';
        
        public $table = 'SHFRI.VW_GEDO_CONTRACTS_DETAILS';


        protected $hidden = [
            'num_police',
            'par_partner_nr',
            'vmr_vermittler_nr',
        ];
    }
