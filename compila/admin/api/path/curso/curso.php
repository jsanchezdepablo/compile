<?php
	class RestCurso{
		// GET curso/get/[idCurso]
		static public function getCurso($id){
			$query = 'SELECT c.* FROM Curso c WHERE c.id = :idCurso';

			$usu = getDatabase()->one($query, array(':idCurso' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET curso/leccion/listado/[idCurso]
		static public function getLecciones($id){
			$query = 'SELECT l.* FROM Curso_Leccion cl, Leccion l WHERE cl.id_Curso = :idCurso AND l.id = cl.id_Leccion';

			$usu = getDatabase()->all($query, array(':idCurso' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET curso/streaming/listado/[idCurso]
		static public function getStreamings($id){
			$query = 'SELECT s.* FROM Streaming_Curso sc, Streaming s WHERE sc.id_curso = :idCurso AND s.id = sc.id_streaming';

			$usu = getDatabase()->all($query, array(':idCurso' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET curso/listado/tema/(\w+)/nivel/(\w+)
		static public function getListaCurso($tema, $nivel){
			$tema=str_replace("_", " ", $tema);
			$query = 'SELECT c.* FROM Curso c ';
			if($tema != 'null'){
				$query .= 'WHERE c.tema = :cursoTema';
				if($nivel != 'null'){
					$query .= ' AND c.nivel >= :cursoNivel';
					$usu = getDatabase()->all($query, array(':cursoTema' => $tema, ':cursoNivel' => $nivel));
				}else{
					$usu = getDatabase()->all($query, array(':cursoTema' => $tema));
				}
			}else if($nivel != 'null'){
				$query .= 'WHERE c.nivel >= :cursoNivel';
				$usu = getDatabase()->all($query, array(':cursoNivel' => $nivel));
			}else{
				$usu = getDatabase()->all($query);
			}

			$json = json_encode($usu);

			echo $json;	
		}
	}

	class RestCursoPost{

		static public function createCurso($nombre,$desc, $nivel, $usu){
			$nombre=str_replace("_", " ", $nombre);
			$desc=str_replace("_", " ", $desc);

			$query = 'INSERT INTO Curso (id, nombre, descripcion, nivel, Login) VALUES (NULL, :nomCurso, :descCurso, :nivCurso, :idUsu)';

			$ej = getDatabase()->execute($query, array(':nomCurso' => $nombre, ':descCurso' => $desc, ':nivCurso' => $nivel, ':idUsu' => $usu));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyCurso($id,$nombre,$desc,$nivel){
			$nombre=str_replace("_", " ", $nombre);
			$desc=str_replace("_", " ", $desc);

			$query = 'UPDATE Curso SET nombre = :nomCurso, descripcion = :descCurso, nivel = :nivCurso WHERE Curso.id = :idCurso';

			$ej = getDatabase()->execute($query, array(':idCurso' => $id, ':nomCurso' => $nombre, ':descCurso' => $desc, ':nivCurso' => $nivel));
			$json = json_encode($ej);

			echo $json;
		}

		static public function deleteCurso($id){
			//primero compruebo si tiene conexion con Curso_Leccion

			$query = 'DELETE FROM Curso_Leccion WHERE Curso_Leccion.id_curso = :idCurso';

			$ej = getDatabase()->execute($query, array(':idCurso' => $id));

			//segundo compruebo si tiene conexion con Aula_Curso

			$query = 'DELETE FROM Aula_Curso WHERE Aula_Curso.id_curso = :idCurso';

			$ej = getDatabase()->execute($query, array(':idCurso' => $id));


			$query = 'DELETE FROM Curso WHERE Curso.id = :idCurso';

			$ej = getDatabase()->execute($query, array(':idCurso' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}
?>