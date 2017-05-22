<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use DB;
use Validator;
use Redirect;
use Storage;
use App\Http\Requests;
use App\Project;

class ProjectController extends Controller
{
    protected $progetti;

    public function __construct(ProjectRepository $projects) {
        $this->middleware('auth');

        $this->progetti = $projects;
    }

    // project section
    public function miei(Request $request)
    {
		$buffer = DB::table('buffer')
					->where([
						'id_user' => $request->user()->id,
					])->first();

		if($buffer) {
			DB::table('projects')
				->where('id', $buffer->id_progetto)
				->delete();
			DB::table('buffer')
				  ->where('id', $buffer->id)
				  ->delete();
		}

        return view('progetti.main', [
			'miei' => 1
		]);
    }

    // get my project in json
    public function getJsonMiei(Request $request)
	{
		
		$progetti = $this->progetti->forUser2($request->user());
	
		$this->completaCodice($progetti);
		return json_encode($progetti);
	}

	public function completaCodice(&$progetti)
	{
		foreach($progetti as $prog) {
			$anno = substr($prog->datainizio, -2);
			if($prog->id_ente != null)
				$prog->ente = DB::table('corporations')
					->where('id', $prog->id_ente)
					->first()->nomeazienda;
			$prog->codice = '::' . $prog->id . '/' . $anno;
		}
	}

	public function index(Request $request)
    {
        return $this->show($request);
    }

    public function show(Request $request)
    {
        return view('progetti.main');
    }

    public function getjson(Request $request)
	{

		$progetti = $this->progetti->forUser($request->user());
		$this->completaCodice($progetti);
		return json_encode($progetti);
	}

	public function aggiungi(Request $request)
    {
        return view('progetti.aggiungi', [
            'utenti' => DB::table('users')
                        ->get(),
            'preventiviconfermati' => DB::table('quotes')
            							->where('legameprogetto', 1)
										->having('usato', '=', 0)
            							->get(),
			'statiemotivi' => DB::table('statiemotiviprogetti')
				->get(),
        ]);
    }

    public function modify(Request $request, Project $project)
    {
		$this->authorize('modify', $project);
        return view('progetti.modifica', [
            'progetto' => DB::table('projects')
                            ->where('id', $project->id)
                            ->first(),
            'files' => DB::table('progetti_files')
                        ->where('id_progetto', $project->id)
                        ->get(),
            'datisensibili' => DB::table('progetti_datisensibili')
                        ->where('id_progetto', $project->id)
                        ->get(),
            'lavorazioni' => DB::table('progetti_lavorazioni')
                        ->where('id_progetto', $project->id)
                        ->get(),
            'partecipanti' => DB::table('progetti_partecipanti')
                                ->where('id_progetto', $project->id)
                                ->get(),
            'utenti' => DB::table('users')
                            ->get(),
            'noteprivate' => DB::table('progetti_noteprivate')
            					->where('id_progetto', $project->id)
            					->get(),
			'statiemotivi' => DB::table('statiemotiviprogetti')
				->get(),
			'statoemotivoselezionato' => DB::table('statiprogetti')
				->where('id_progetto', $project->id)
				->first(),
        ]);
    }
}
