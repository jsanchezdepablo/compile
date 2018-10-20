<?php
	class RestGestor{
		// GET usuario/admin/gest/listado/[orden]
		static public function getListaGest($orden){
			$query = 'SELECT u.* FROM Gestor g, Usuario u WHERE g.Login = u.Login ';

			//orden = login/nombre/apellidos
			switch($orden){
				case 'login':
					$query .= 'ORDER BY login';
				break;
				case 'nombre':
					$query .= 'ORDER BY nombre, apellidos';
				break;
				case 'apellidos':
					$query .= 'ORDER BY apellidos, nombre';
				break;
				default:
					$query .= 'ORDER BY Login';
				break;
			}

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;
		}

		// GET usuario/admin/gest/validaciones/[loginGestor]
		static public function getValidaciones($login){
			$query = 'SELECT e.* FROM Ejercicio e WHERE e.Login_ges = :loginGestor ORDER BY e.id';

			$usu = getDatabase()->all($query, array(':loginGestor' => $login));
			$json = json_encode($usu);

			echo $json;
		}
	}

	class RestGestorPost{

		static public function createGestor($usu){
			$query = 'INSERT INTO Gestor (Login) VALUES (:idUsu)';

			$ej = getDatabase()->execute($query, array( ':idUsu' => $usu));
			$json = json_encode($ej);

			echo $json;
		}

		static public function deleteGestor($id){
			//primero compruebo si tiene conexion con Aulas_Curso
			$query = 'DELETE FROM Gestor WHERE Gestor.Login = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}
?>