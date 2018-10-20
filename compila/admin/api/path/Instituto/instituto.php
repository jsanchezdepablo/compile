<?php
	class RestInstituto{

		// GET instituto/get/[nombreInsti]
		static public function getInsti($id){
			$id=str_replace("_", " ", $id);
			$query = 'SELECT i.* FROM Instituto i WHERE i.nombre = :idInsti';

			$usu = getDatabase()->one($query, array(':idInsti' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET instituto/listado
		static public function getListaInsti($id){
			$id=str_replace("_", " ", $id);
			$query = 'SELECT * FROM Instituto';

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;	
		}

		// GET instituto/alumno/listado/[nombreInstituto]/profesor/[loginProf]
		static public function getAlumnos($id, $login){
			$id=str_replace("_", " ", $id);
			$query = 'SELECT iap.login_prof, a.* FROM Ins_alu_prof iap, Alumno a, Profesor p WHERE iap.nombre_insti = :idInsti AND iap.login_alu = a.Login';
			if($login != 'null'){
				$query .= ' AND iap.login_prof = :loginProf';
				$usu = getDatabase()->all($query, array(':idInsti' => $id, ':loginProf' => $login));
			}else{
				$usu = getDatabase()->all($query, array(':idInsti' => $id));
			}

			$json = json_encode($usu);

			echo $json;	
		}

		// GET instituto/profesor/listado/[nombreInsti]
		static public function getProfesores($id){
			$insti=str_replace("_", " ", $insti);
			$query = 'SELECT DISTINCT iap.login_prof FROM Ins_alu_prof iap WHERE iap.nombre_insti = :idInsti';

			$usu = getDatabase()->all($query, array(':idInsti' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET instituto/curso/listado/[nombreInsti]
		static public function getCursos($insti){
			$insti=str_replace("_", " ", $insti);
			$query = 'SELECT cr.*, ci.fecha, ci.plazo, p.descuento FROM Compra_Instituto ci, Pack p, Curso_Pack cp, Curso cr WHERE ci.nombre_insti = :nombreInsti AND ci.id_pack = p.id AND p.id = cp.id_Pack AND cp.id_Curso = cr.id';

			$usu = getDatabase()->all($query, array(':nombreInsti' => $insti));
			$json = json_encode($usu);

			echo $json;	
		}
	}

	class RestInstitutoPost{

		// "/instituto/crear/nombre/(\w+)/direccion/(\w+)/email/(w+)
		static public function createInstituto($nombre,$dir, $em){
			$nombre=str_replace("_", " ", $nombre);
			$dir=str_replace("_", " ", $dir);

			$query = 'INSERT INTO Instituto (nombre, direccion, mail) VALUES (:nom, :direc, :email)';

			$ej = getDatabase()->execute($query, array(':nom' => $nombre, ':direc' => $dir, ':email' => $em));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyInstituto($id,$nombre,$dir, $em){
			$nombre=str_replace("_", " ", $nombre);
			$id=str_replace("_", " ", $id);
			$dir=str_replace("_", " ", $dir);
			//el email se pasa pero habra que encontrar una forma de pasarlo ya que el '@' y el '.' no se pueden pasar poe la URL
			$query = 'UPDATE Instituto SET nombre = :nom, direccion = :direc, mail = :email WHERE Instituto.nombre = :idins';

			$ej = getDatabase()->execute($query, array(':idins' => $id, ':nom' => $nombre, ':direc' => $dir, ':email' => $em));
			$json = json_encode($ej);

			echo $json;
		}


		static public function deleteInstituto($id){
			$id=str_replace("_", " ", $id);
			//primero compruebo si tiene conexion con Aulas_Curso

			/*$query = 'DELETE FROM Ins_alu_prof i WHERE i.nombre_insti = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));*/


			$query = 'DELETE FROM Instituto WHERE Instituto.nombre = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}

	}
?>