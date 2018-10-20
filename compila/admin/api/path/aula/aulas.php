<?php
	class RestAulas{
		// GET /aula/get/[idaula]
		static public function getAula($id){
			$query = 'SELECT * FROM Aula WHERE id = :idAula;';

			$ej = getDatabase()->all($query, array(':idAula' => $id));
			$json = json_encode($ej);

			echo $json;
		}
		// GET /aula/listado
		static public function getListaAulas(){
			$query = 'SELECT * FROM Aula;';

			$ej = getDatabase()->all($query);
			$json = json_encode($ej);

			echo $json;
		}
		// GET aula/nombre/$nombreAula
		static public function getAulasPorNombre($nombre){
			$nombre=str_replace("_", " ", $nombre);

			$query = 'SELECT * FROM Aula a WHERE a.nombre = :nomAula ORDER BY nombre';

			$ej = getDatabase()->all($query, array(':nomAula' => $nombre));
			$json = json_encode($ej);

			echo $json;
		}
		// GET aula/noticias/listado/[idAula]
		static public function getNoticiasAula($id){
			$query = 'SELECT n.* FROM Noticias_Aula na, Noticias n WHERE na.id_aula = :idAula AND n.id = na.id_noticia ORDER BY n.id';

			$ej = getDatabase()->all($query, array(':idAula' => $id));
			$json = json_encode($ej);

			echo $json;
		}

		// GET aula/alumnos/listado/[idAula]
		static public function getAlumnosAula($id){
			$query = 'SELECT * FROM Alumno_Aula n, Alumno a WHERE n.id_aula = :idAula AND n.login_alu = a.Login';

			$ej = getDatabase()->all($query, array(':idAula' => $id));
			$json = json_encode($ej);

			echo $json;
		}

		// GET aula/cursos/listado/[idAula]
		static public function getCursosAula($id){
			$query = "SELECT c.* FROM Aula_Curso a, Curso c WHERE a.id_aula = :idAula AND a.id_curso = c.id";

			$ej = getDatabase()->all($query, array(':idAula' => $id));
			$json = json_encode($ej);

			echo $json;
		}

		/*// GET crearaula/nombre/$nomAula/usuario/$nomUsu
		static public function createAula($nombre,$usu){
			$query = "INSERT INTO Aula (id, nombre, Login) VALUES (NULL, ':nomAula', ':idUsu')";

			$ej = getDatabase()->all($query, array(':nomAula' => $nombre', :idUsu' => $usu));
			$json = json_encode($ej);

			echo $json;
		}*/
	}
	class RestAulasPost{
		// crearaula/nombre/$nomAula/usuario/$nomUsu
		static public function createAula($nombre,$usu){
			$nombre=str_replace("_", " ", $nombre);
			$query = 'INSERT INTO Aula (id, nombre, Login) VALUES (NULL, :nomAula, :idUsu)';

			$ej = getDatabase()->execute($query, array(':nomAula' => $nombre, ':idUsu' => $usu));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyAula($id,$nombre){
			$nombre=str_replace("_", " ", $nombre);
			$query = 'UPDATE Aula SET nombre = :nomAula WHERE Aula.id = :idAula';

			$ej = getDatabase()->execute($query, array(':idAula' => $id, ':nomAula' => $nombre));
			$json = json_encode($ej);

			echo $json;
		}


		static public function deleteAula($id){
			//primero compruebo si tiene conexion con Aulas_Curso

			$query = 'DELETE FROM Aula_Curso WHERE Aula_Curso.id_aula = :idAula';

			$ej = getDatabase()->execute($query, array(':idAula' => $id));


			$query = 'DELETE FROM Aula WHERE Aula.id = :idAula';

			$ej = getDatabase()->execute($query, array(':idAula' => $id));
			$json = json_encode($ej);

			echo $json;
		}

	}

?>
