<?php
	class RestFree{
		// GET usuario/usureg/prem/listado
		static public function getListaFree(){
			$query = 'SELECT * FROM Free';

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;		
		}
	}
	class RestFreePost{

		static public function createFree($usu){
			
			/*$query = 'INSERT INTO UsuarioRegistrado (Login) VALUES (:idUsu)';
			$ej = getDatabase()->execute($query, array(':idUsu' => $usu));*/

			$query = 'INSERT INTO Free (Login) VALUES (:idUsu)';

			
			$json = json_encode($ej);

			echo $json;
		}

		static public function deleteFree($id){
			//primero compruebo si tiene conexion con Aulas_Curso

			$query = 'DELETE FROM Free WHERE Free.Login = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}
?>