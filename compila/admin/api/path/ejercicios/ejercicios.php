<?php
	class RestEjercicios{

		// GET /ejercicio/get/[idEjercicio]
		static public function getEjercicio($id){
			$query = 'SELECT * FROM Ejercicio e WHERE e.id = :idEjercicio';

			$ej = getDatabase()->one($query, array(':idEjercicio' => $id));
			$json = json_encode($ej);

			echo $json;
		}

		// GET /ejercicio/listado/valoracion/[nValoracion]/tema/[tipoDeTema]
		static public function getListaEjercicios($valor, $tema){
			$tema=str_replace("_", " ", $tema);
			$query = 'SELECT * FROM Ejercicio e ';

			if($valor != 0){
				$query .= 'WHERE e.valoracion >= :dataValor';
				if($tema != 'null'){
					$query .= ' AND e.tema = :dataTema';
					$ej = getDatabase()->all($query, array(':dataValor' => $valor, ':dataTema' => $tema));
				}else{
					$ej = getDatabase()->all($query, array(':dataValor' => $valor));
				}
			}else if($tema != 'null'){
				$query .= 'WHERE e.tema >= :dataTema';
				$ej = getDatabase()->all($query, array(':dataTema' => $tema));
			}else{
				$ej = getDatabase()->all($query);
			}

			$json = json_encode($ej);

			echo $json;
		}

		// GET /ejercicio/juego/listado
		static public function getListaVideojuegos(){
			$query = 'SELECT e.*, j.url_serv FROM Ejercicio e, Juego j WHERE e.id = j.id';

			$ej = getDatabase()->all($query);
			$json = json_encode($ej);

			echo $json;
		}

		// GET /ejercicio/juego/get/[idJuego]
		static public function getVideojuego($id){
			$query = 'SELECT e.*, j.url_serv FROM Ejercicio e, Juego j WHERE e.id = j.id AND e.id = :idJuego';

			$ej = getDatabase()->one($query, array(':idJuego' => $id));
			$json = json_encode($ej);

			echo $json;
		}

		// GET /ejercicio/normal/listado
		static public function getListaNormal(){
			$query = 'SELECT e.*, n.pregunta, n.respuesta FROM Ejercicio e, NormalEj n WHERE e.id = n.id';

			$ej = getDatabase()->all($query);
			$json = json_encode($ej);

			echo $json;
		}

		// GET /ejercicio/normal/get/[idNormal]
		static public function getNormal($id){
			$query = 'SELECT e.*, n.pregunta, n.respuesta FROM Ejercicio e, NormalEj n WHERE e.id = n.id AND e.id = :idNormal';

			$ej = getDatabase()->one($query, array(':idNormal' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}

	class RestEjerciciosPost{

		static public function createEjercicio($desc,$tema,$usu,$gest){

			$desc=str_replace("_", " ", $desc);
			$tema=str_replace("_", " ", $tema);
			$query = 'INSERT INTO Ejercicio (id, valoracion, descripcion, tema, Login_usu, Login_ges) VALUES (NULL, "0", :des, :tema, :usu, :gest)';

			$ej = getDatabase()->execute($query, array(':des' => $desc, ':tema' => $tema, ':usu' => $usu, ':gest' => $gest));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyEjercicio($id,$desc,$tema){
			$desc=str_replace("_", " ", $desc);
			$tema=str_replace("_", " ", $tema);
			$query = 'UPDATE Ejercicio SET descripcion = :des, tema= :tema WHERE Ejercicio.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':des' => $desc, ':tema' => $tema));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyEjercicioDesc($id,$desc){
			$desc=str_replace("_", " ", $desc);

			$query = 'UPDATE Ejercicio SET descripcion = :des WHERE Ejercicio.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':des' => $desc));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyEjercicioTema($id,$tema){
			$tema=str_replace("_", " ", $tema);
			$query = 'UPDATE Ejercicio SET tema= :tema WHERE Ejercicio.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':tema' => $tema));
			$json = json_encode($ej);

			echo $json;
		}

		static public function deleteEjercicio($id){
			//primero compruebo si tiene conexion con NormalEj
			$query1 = 'DELETE FROM NormalEj WHERE NormalEj.id = :id';
			$ej1 = getDatabase()->execute($query1, array(':id' => $id));
			$json1 = json_encode($ej1);

			$query1 = 'DELETE FROM Sube WHERE Sube.id_ej = :id';
			$ej1 = getDatabase()->execute($query1, array(':id' => $id));
			$json1 = json_encode($ej1);

			$query1 = 'DELETE FROM Juego WHERE Juego.id = :id';
			$ej1 = getDatabase()->execute($query1, array(':id' => $id));
			$json1 = json_encode($ej1);

			/*$query1 = 'DELETE FROM Leccion_Ejercicio WHERE Leccion_Ejercicio.id_ejercicio = :id AND Leccion_Ejercicio.id_leccion IN (SELECT * FROM Leccion) ';
			$ej1 = getDatabase()->execute($query1, array(':id' => $id));
			$json1 = json_encode($ej1);*/

			$query = 'DELETE FROM Ejercicio WHERE Ejercicio.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}
?>