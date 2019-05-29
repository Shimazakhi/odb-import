<?php

    namespace App\Transformers;

    use Carbon\Carbon;

    use App\Models\Contact;
    use League\Fractal\TransformerAbstract;

    /**
     * Data formatter
     *
     * Class OracleClaimTransformer
     *
     * @package App\Transformers
     */
    class OracleClaimTransformer extends TransformerAbstract
    {
        /**
         * Transform
         *
         * @param $customer
         */
        public function transform($claim)
        {
            return [
                'external_id'     => $claim['sch_schaden_nr'] ?? null,
                'contract_number' => $claim['pol_policen_nr'] ?? null,
                'happened_at'     => $claim['sch_schadendatum'] ?? null,
                'damage_type'     => $claim['sch_schadenart'] ?? null,
                'department_code' => $claim['department_code'] ?? null,
                'note'            => $claim['sch_notiz'] ?? null,

                'plot_number'           => $claim['sqr_quotenposition_nr'] ?? null,
                'object_number'           => $claim['obj_objekt_nr'] ?? null,
                'insee'                 => $claim['insee_position'] ?? null,
                'plot_name'             => $claim['nom_position'] ?? null,
                'crop_code'             => $claim['code_culture'] ?? null,
                'crop_name'             => $claim['culture'] ?? null,
                'crop_variety'          => $claim['variete'] ?? null,
                'plot_surface'          => $claim['superficie'] ?? null,
                'yield'                 => $claim['rendement'] ?? null,
                'yield_increase'        => $claim['augmentation de rendement'] ?? null,
                'unit_price'            => $claim['prix_unitaire'] ?? null,
                'deductible_hail_plot'  => $claim['franchise_grele_parcelle'] ?? null,
                'storm_plot'            => $claim['tempete_parcelle'] ?? null,
                'deductible_storm_plot' => $claim['franchise_tempete_parcelle'] ?? null,
                'quality'               => $claim['qualite'] ?? null,
                'sandstorm'             => $claim['vds'] ?? null,
                'harvest_in'            => $claim['sqr_erntetermin'] ?? null,
                'capital_sum_estimation'=> $claim['capital_sum_estimation'] ?? null,

                'damaged' => $this->getDamageStatus($claim['sqr_betroffen']),
            ];
        }

        private function getDamageStatus($value)
        {
            if ($value != 'nicht betroffen') {
                return true;
            }
            return false;
        }
    }
