<?php
	class RestAdministrador{
		// GET usuario/admin/listado/[orden]
		static public function getListaAdmin($orden){
			$query = 'SELECT u.* FROM Administrador a, Usuario u WHERE a.Login = u.Login ';

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
					$query .= 'ORDER BY login';
				break;
			}

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;		
		}

		// GET usuario/admin/cursos/listado/[loginAdmin]
		static public function getCursos($login){
			$query = 'SELECT * FROM Curso c WHERE Login = :loginAdmin';

			$usu = getDatabase()->all($query, array(':loginAdmin' => $login));
			$json = json_encode($usu);

			echo $json;	
		}
	}

	class RestAdministradorPost{

		static public function createAdmin($usu){
			$query = 'INSERT INTO Administrador (Login) VALUES (:idUsu)';

			$ej = getDatabase()->execute($query, array( ':idUsu' => $usu));
			$json = json_encode($ej);

			echo $json;
		}

		static public function deleteAdmin($id){
			//primero compruebo si tiene conexion con Aulas_Curso
			$query = 'DELETE FROM Administrador WHERE Administrador.Login = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}
?>