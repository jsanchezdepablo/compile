<?php
	class RestLeccion{
		// GET leccion/get/(\w+)
		static public function getLeccion($id){
			$query = 'SELECT * FROM Leccion l WHERE l.id = :idLeccion';

			$usu = getDatabase()->one($query, array(':idLeccion' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET leccion/listado
		static public function getListaLeccion(){
			$query = 'SELECT * FROM Leccion l';

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;	
		}

		// GET leccion/ejercicios/listado/(\w+)
		static public function getEjercicios($id){
			$query = 'SELECT e.* FROM Leccion_Ejercicio le, Ejercicio e WHERE le.id_leccion = :idLeccion AND e.id = le.id_ejercicio ORDER BY e.id';

			$usu = getDatabase()->all($query, array(':idLeccion' => $id));
			$json = json_encode($usu);

			echo $json;	
		}
	}

	class RestLeccionPost{

		static public function createLeccion($nombre,$vid,$pdf){
			$nombre=str_replace("_", " ", $nombre);
			$query = 'INSERT INTO Leccion (id, nombre, url_video, url_pdf) VALUES (NULL, :nom, :vid, :pdf)';

			$ej = getDatabase()->execute($query, array(':nom' => $nombre, ':vid' => $vid, ':pdf' => $pdf));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyLeccion($id,$nombre,$vid,$pdf){
			$nombre=str_replace("_", " ", $nombre);
			$query = 'UPDATE Leccion SET nombre = :nom, url_video = :vid, url_pdf = :pdf WHERE Leccion.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':nom' => $nombre, ':vid' => $vid, ':pdf' => $pdf));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyLeccionNombre($id,$nombre){
			$nombre=str_replace("_", " ", $nombre);
			$query = 'UPDATE Leccion SET nombre = :nom WHERE Leccion.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':nom' => $nombre));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyLeccionVideo($id,$video){
			
			$query = 'UPDATE Leccion SET url_video = :vid WHERE Leccion.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':vid' => $video));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyLeccionPdf($id,$pdf){
			
			$query = 'UPDATE Leccion SET url_pdf = :pdf WHERE Leccion.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':pdf' => $pdf));
			$json = json_encode($ej);

			echo $json;
		}

		static public function deleteLeccion($id){

			$query = 'DELETE FROM Leccion WHERE Leccion.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}


	}
?>