<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RaceYear;
use App\Models\Race;
use App\Models\Stage;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use Override;
use Config\Config;

class RaceC extends BaseController
{
    protected $raceYear;
    protected $race;
    protected $Config;
    public $rokZavodu;

    #[Override]
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->raceYear = new RaceYear();
        $this->race = new Race();
        $this->Config = new Config();
    }

    public function show($idZavod)
    {
        // Načteme pouze jeden konkrétní závod podle ID
        $raceYearRow = $this->raceYear->find($idZavod);

        if (!$raceYearRow) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Závod s ID $idZavod nebyl nalezen.");
        }

        $rok = is_object($raceYearRow) ? $raceYearRow->year : $raceYearRow['year'];
        $id = is_object($raceYearRow) ? $raceYearRow->id : $raceYearRow['id'];

        // VÝPOČET DAT PRO JEDEN ZÁVOD
        $stageModel = new Stage();

        // Spočítáme sumu vzdáleností
        $distanceResult = $stageModel->where('id_race_year', $id)->selectSum('distance')->get()->getRow();
        $raceYearRow->total_distance = $distanceResult ? $distanceResult->distance : 0;

        // Spočítáme sumu převýšení
        $elevationResult = $stageModel->where('id_race_year', $id)->selectSum('vertical_meters', 'elevation')->get()->getRow();
        $raceYearRow->total_elevation = $elevationResult ? $elevationResult->elevation : 0;

        $data = [
            'idZavod' => $idZavod,
            'zavod'   => $raceYearRow, // Předáváme jako hlavní objekt
            'year'    => $rok
        ];

        return view('race', $data);
    }
}
