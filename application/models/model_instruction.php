<?php
class Model_Instruction extends Model
{
	private $text_file = "application/includes/txt/instruction.txt";
	
	public function get_data()
	{	
		if(isset($_SESSION['people_id'])){
			$data = $this->text_file;
			return $data;			
		}
	}
}
?>