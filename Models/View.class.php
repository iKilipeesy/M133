
<?/*
 * Author: Kenny Betschart
 * Date: 10.12.2019
 * Project: myBlog
 * Filename: view.class
 * Description: Class to show the html files
 */

class View {
	private $name = null;
	private $innerhtml = null;
	
	public function __construct($name, $preload=true, $predisplay=true) {
		$this->name = $name;
		if($preload) {
			$this->load();
		}
		if($predisplay) { 
			$this->display();
		}
	}
	
	public function load() {
		$this->innerhtml = file_get_contents(__DIR__."/../".VIEWS_PATH.$this->name.".html");
	}
	
	public function display() {
		echo $this->innerhtml;
	}

	public function set_placeholder($key, $value) {
		$this->innerhtml = preg_replace("/{".$key."}/", $value, $this->innerhtml);
	}
}
?>