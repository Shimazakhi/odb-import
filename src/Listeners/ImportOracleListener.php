<?php

    namespace App\Listeners;

    use App\Events\ImportOracleEvent;
    use App\Services\OracleImportService;

    class ImportOracleListener
    {

        /**
         * @param \App\Events\ImportOracleEvent $event
         * @throws \Exception
         */
        public function handle(ImportOracleEvent $event)
        {
            print_r("----------------------\n");

            print_r("Contracts Import Started\n");
            (new OracleImportService())->processContractsImport();
            print_r("Contracts Import Finished\n");


            print_r("----------------------\n");

            print_r("Claims Import Started\n");
            (new OracleImportService())->processClaimsImport();
            print_r("Claims Import Finished\n");


            print_r("----------------------\n");
        }

    }
