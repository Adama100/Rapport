<?php

    namespace App\Domain\Rapport\Table;

    use App\Domain\Application\Abstract\AbstractTable;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

    class ReportTable extends AbstractTable {

        protected $table = "reports";
        protected $class = Report::class;

    }