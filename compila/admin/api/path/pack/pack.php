<?php
	class RestPack{
		// GET pack/get/[idCurso]
		static public function getPack($id){
			$query = 'SELECT p.* FROM Pack p WHERE p.id = :idPack';

			$usu = getDatabase()->one($query, array(':idPack' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET pack/listado
		static public function getListaPack(){
			$query = 'SELECT p.* FROM Pack p';

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;	
		}

		// GET pack/curso/listado/[idPack]
		static public function getCursos($id){
			$query = 'SELECT c.* FROM Curso_Pack cp, Curso c WHERE cp.id_Pack = :idPack AND c.id = cp.id_Curso';

			$usu = getDatabase()->all($query, array(':idPack' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET pack/usureg/listado/[idPack]
		static public function getUsuarios($id){
			$query = 'SELECT c.login_usuR, c.fecha, c.plazo FROM Comprar c WHERE c.id_pack = :idPack';

			$usu = getDatabase()->all($query, array(':idPack' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET pack/instituto/listado/[idPack]
		static public function getInstitutos($id){
			$query = 'SELECT ci.nombre_insti, ci.fecha, ci.plazo FROM Compra_Instituto ci WHERE ci.id_pack = :idPack';

			$usu = getDatabase()->all($query, array(':idPack' => $id));
			$json = json_encode($usu);

			echo $json;	
		}
	}

	class RestPackPost{


		static public function createPack($desc){
			
			$query = 'INSERT INTO Pack (id, descuento) VALUES (NULL, :des)';

			$ej = getDatabase()->execute($query, array(':des' => $desc));
			$json = json_encode($ej);

			echo $json;
		}


		static public function modifyPack($id, $desc){
			
			$query = 'UPDATE Pack SET descuento = :des WHERE Pack.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':des' => $desc));
			$json = json_encode($ej);

			echo $json;
		}


		static public function deletePack($id){
	
			$query = 'DELETE FROM Pack WHERE Pack.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}
?>