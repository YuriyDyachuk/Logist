<?php
namespace App\Services;

use App\Models\Instructions;
use Illuminate\Support\Facades\File;

class InstructionsService
{

	public function saveOrUpdate($request, $id){

		if($id == 0)
			$instruction = new Instructions();
		else
			$instruction = Instructions::findOrFail($id);

		$instruction->fill([
			'type' => $request->get('type'),
			'slug' => str_slug($request->get('slug')),
			'list' => $request->get('list'),
			'parent_id' => $request->get('parent_id')
		]);

		$instruction->save();
		$this->updateLangFiles($request, $id);
	}

	protected function updateLangFiles($request, $id){

		$slug = str_slug($request->get('slug'));
		$titles = $request->get('title');
		$texts = $request->get('text');


		foreach(config('app.locales') as $key => $locale){

			$content = $this->getLangFile($key);


			$content[$slug.'_title']    = $titles[$key];
			$content[$slug . '_html']   = $texts[$key];


			$output = "<?php\n\nreturn ".var_export($content, true).";\n";

			$file   = $this->getLocaleFilePath($key);
			File::put($file, preg_replace("/ \R/", "\n", $output));
		}
	}

	protected function getLangFile($locale){
		$path = $this->getLocaleFilePath($locale);
		$content = include_once($path);
		return $content;
	}

	protected function getLocaleFilePath($locale){
		return resource_path(DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$locale.DIRECTORY_SEPARATOR.'instructions.php');
	}


	public function getInstructionData(&$intstruction){

		$title  = [];
		$text   = [];

		foreach(config('app.locales') as $key => $locale){
			$content = $this->getLangFile($key);

			isset($content[$intstruction->slug.'_title']) ? $title[$key] = $content[$intstruction->slug.'_title'] : $title[$key] = '';
			isset($content[$intstruction->slug.'_html']) ? $text[$key] = $content[$intstruction->slug.'_html'] : $text[$key] = '';

		}

		$intstruction->title = $title;
		$intstruction->text = $text;
	}

}