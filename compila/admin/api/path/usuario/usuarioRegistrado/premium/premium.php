<?php
	class RestPremium{
		// GET usuario/usureg/prem/listado/[orden]
		static public function getListaPrem($orden){
			$query = 'SELECT u.* FROM Premium p, Usuario u WHERE u.Login = p.Login ';

			//orden = login/nombre/apellidos
			switch($orden){
				case 'login':
					$query .= 'ORDER BY Login';
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
	}

	class RestPremiumPost{

		static public function createPremium($usu){
			$query = 'INSERT INTO Premium (Login) VALUES (:idUsu)';

			$ej = getDatabase()->execute($query, array( ':idUsu' => $usu));
			$json = json_encode($ej);

			echo $json;
		}

		static public function deletePremium($id){
			//primero compruebo si tiene conexion con Aulas_Curso
			$query = 'DELETE FROM Premium WHERE Premium.Login = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}
?>