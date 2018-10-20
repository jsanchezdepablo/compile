<?php
	class RestStreaming{
		// GET streaming/get/[idStreaming]
		static public function getStreaming($id){
			$query = 'SELECT s.* FROM Streaming s WHERE s.id = :idStreaming';

			$usu = getDatabase()->one($query, array(':idStreaming' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET streaming/listado
		static public function getListaStreaming(){
			$query = 'SELECT * FROM Streaming ORDER BY fecha';

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;	
		}

		// GET streaming/curso/listado/[idStreaming]
		static public function getCursos($id){
			$query = 'SELECT c.* FROM Streaming_Curso cs, Curso c WHERE cs.id_streaming = :idStreaming AND c.id = cs.id_curso';

			$usu = getDatabase()->all($query, array(':idStreaming' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET streaming/aula/listado/[idStreaming]
		static public function getAulas($id){
			$query = 'SELECT a.* FROM Streaming_Aula sa, Aula a WHERE sa.id_streaming = :idAula AND a.id = sa.id_aula';

			$usu = getDatabase()->all($query, array(':idAula' => $id));
			$json = json_encode($usu);

			echo $json;	
		}
	}

	class RestStreamingPost{

		static public function createStreaming($fecha,$desc,$url,$id){
			$query = 'INSERT INTO Streaming (id, fecha, descripcion,url, Login) VALUES (NULL, :fecha, :des, :url, :id)';

			$ej = getDatabase()->execute($query, array(':fecha' => $fecha, ':des' => $desc, ':url' => $url, ':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyStreaming($id,$fecha,$desc,$url){
			$desc=str_replace("_", " ", $desc);
			$query = 'UPDATE Streaming SET fecha = :fecha, descripcion = :des, url = :url  WHERE Streaming.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':fecha' => $fecha, ':des' => $desc, ':url' => $url));
			$json = json_encode($ej);

			echo $json;
		}


		static public function modifyStreamingFecha($id,$fecha){
			
			$query = 'UPDATE Streaming SET fecha = :fecha WHERE Streaming.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':fecha' => $fecha));
			$json = json_encode($ej);

			echo $json;
		}


		static public function modifyStreamingDesc($id,$desc){
			$desc=str_replace("_", " ", $desc);
			$query = 'UPDATE Streaming SET descripcion = :des WHERE Streaming.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':des' => $desc));
			$json = json_encode($ej);

			echo $json;
		}


		static public function modifyStreamingUrl($id,$url){
			
			$query = 'UPDATE Streaming SET url = :url WHERE Streaming.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':url' => $url));
			$json = json_encode($ej);

			echo $json;
		}

		static public function deleteStreaming($id){
			//primero compruebo si tiene conexion con Aulas_Curso
			//$query1 ='SELECT a.id FROM Aula a';
			//$ej1 = getDatabase()->execute($query1);

/*
			$query = 'DELETE FROM Aula_Curso WHERE Aula_Curso.id_aula = :idAula';

			$ej = getDatabase()->execute($query, array(':idAula' => $id));*/

			$query = 'DELETE sa.* FROM Streaming_Aula sa, Aula a WHERE sa.id_streaming = :id AND sa.id_aula= a.id';
			$ej = getDatabase()->execute($query, array(':id' => $id));

			$query = 'DELETE sc.* FROM Streaming_Curso sc, Aula a WHERE sc.id_streaming = :id AND sc.id_curso= a.id';
			$ej = getDatabase()->execute($query, array(':id' => $id));


			$query = 'DELETE FROM Streaming WHERE Streaming.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

		}


		static public function createStreamingAula($idStream,$idAula){
			$query = 'INSERT INTO Streaming_Aula (id_streaming, id_aula) VALUES ( :idStream, :idAula)';

			$ej = getDatabase()->execute($query, array(':idStream' => $idStream, ':idAula' => $idAula));
			$json = json_encode($ej);

			echo $json;
		}


		static public function deleteStreamingAula($idStream,$idAula){


			$query = 'DELETE FROM Streaming_Aula WHERE Streaming_Aula.id_streaming = :idStream AND Streaming_Aula.id_aula = :idAula';

			$ej = getDatabase()->execute($query, array(':idStream' => $idStream, ':idAula' => $idAula));
			$json = json_encode($ej);

		}

		static public function createStreamingCurso($idStream,$idCurso){
			$query = 'INSERT INTO Streaming_Curso (id_streaming, id_curso) VALUES ( :idStream, :idCurso)';

			$ej = getDatabase()->execute($query, array(':idStream' => $idStream, ':idCurso' => $idCurso));
			$json = json_encode($ej);

			echo $json;
		}


		static public function deleteStreamingCurso($idStream,$idCurso){

			$query = 'DELETE FROM Streaming_Curso WHERE Streaming_Curso.id_streaming = :idStream AND Streaming_Curso.id_curso = :idCurso';

			$ej = getDatabase()->execute($query, array(':idStream' => $idStream, ':idCurso' => $idCurso));
			$json = json_encode($ej);

		}
	}
?>