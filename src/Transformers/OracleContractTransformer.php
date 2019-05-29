<?php

    namespace App\Transformers;

    use Carbon\Carbon;

    use App\Models\Contact;
    use League\Fractal\TransformerAbstract;

    /**
     * Data formatter
     *
     * Class OracleContractTransformer
     *
     * @package App\Transformers
     */
    class OracleContractTransformer extends TransformerAbstract
    {
        /**
         * Transform
         *
         * @param $customer
         */
        public function transform($contract)
        {
            $contract = (object)$contract;

            $data = [
                'contract_number'           => $contract->pol_policen_nr,
                'offer'                     => $contract->offer,
                'product'                   => $contract->product,
                'deductible_hazards_option' => $contract->franchise_aleas,
                'deductible_hail_option'    => $contract->franchise_grele,
                'option1'                   => $contract['mrc-resemis_grele-gel'],
                'option2'                   => $contract['mrc-supprecolte_grele-qualite'],
                'clauses'                   => $contract['clauses'],
                'note'                      => $contract['ver_notiz'],
                'insee'                     => $contract['insee'],
                /** Customer */

                'customer_code'      => $contract->customer_num,
                'customer_firstname' => $contract->customer_firstname,
                'customer_lastname'  => $contract->customer_lastname,
                'customer_company'   => $contract->customer_company,
                'customer_landline'  => $contract->customer_landline,
                'customer_mobile'    => $contract->customer_mobile,
                'customer_fax'       => $contract->customer_fax,
                'customer_email'     => $contract->customer_email,
                'customer_address1'  => $contract->customer_address1,
                'customer_address2'  => $contract->customer_assress2,
                'customer_zipcode'   => $contract->customer_zipcode,
                'customer_city'      => $contract->customer_city,
                /** Agent */
                'agent_code'      => $contract->agent_num,
                'agent_firstname' => $contract->agent_firstname,
                'agent_lastname'  => $contract->agent_lastname,
                'agent_company'   => $contract->agent_company,
                'agent_landline'  => $contract->agent_landline,
                'agent_mobile'    => $contract->agent_mobile,
                'agent_fax'       => $contract->agent_fax,
                'agent_email'     => $contract->agent_email,
                'agent_address1'  => $contract->agent_address1,
                'agent_address2'  => $contract->agent_assress2,
                'agent_zipcode'   => $contract->agent_zipcode,
                'agent_city'      => $contract->agent_city,
            ];


            return $data;
        }
    }
