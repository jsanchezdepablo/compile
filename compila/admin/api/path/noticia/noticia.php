<?php
	class RestNoticia{
		// GET noticia/get/[idNoticia]
		static public function getNoticia($id){
			$query = 'SELECT n.* FROM Noticias n WHERE n.id = :idNoticia';

			$usu = getDatabase()->one($query, array(':idNoticia' => $id));
			$json = json_encode($usu);

			echo $json;
		}

		// GET noticia/listado/
		static public function getListaNoticias(){
			$query = 'SELECT * FROM Noticias ORDER BY id';

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;	
		}

		// GET noticia/cursos/listado/[idNoticia]
		static public function getCursos($id){
			$query = 'SELECT nc.id_curso FROM Noticia_Curso nc WHERE nc.id_noticia = :idNoticia';

			$usu = getDatabase()->all($query, array(':idNoticia' => $id));
			$json = json_encode($usu);

			echo $json;	
		}

		// GET noticia/aulas/listado/[idNoticia]
		static public function getAulas($id){
			$query = 'SELECT a.* FROM Noticias_Aula na, Aula a WHERE na.id_noticia = :idNoticia AND a.id = na.id_aula ORDER BY a.nombre';

			$usu = getDatabase()->all($query, array(':idNoticia' => $id));
			$json = json_encode($usu);

			echo $json;	
		}
	}

	class RestNoticiaPost{


		static public function createNoticia($asunto,$msg,$login){
			$asunto=str_replace("_", " ", $asunto);
			$msg=str_replace("_", " ", $msg);

			$query = 'INSERT INTO Noticias (id, asunto, mensage, login_admin) VALUES (NULL, :asunto, :msg, :log)';

			$ej = getDatabase()->execute($query, array(':asunto' => $asunto, ':msg' => $msg, ':log' => $login));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyNoticia($id,$asunto,$msg){
			$asunto=str_replace("_", " ", $asunto);
			$msg=str_replace("_", " ", $msg);

			$query = 'UPDATE Noticias SET asunto = :asunto, mensage = :msg WHERE Noticias.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id,':asunto' => $asunto, ':msg' => $msg));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyNoticiaAsunto($id,$asunto){
			$asunto=str_replace("_", " ", $asunto);

			$query = 'UPDATE Noticias SET asunto = :asunto WHERE Noticias.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id,':asunto' => $asunto));
			$json = json_encode($ej);

			echo $json;
		}

		static public function modifyNoticiaMensaje($id,$msg){
			$msg= str_replace("_", " ", $msg);

			$query = 'UPDATE Noticias SET mensage = :msg WHERE Noticias.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id, ':msg' => $msg));
			$json = json_encode($ej);

			echo $json;
		}

		static public function deleteNoticia($id){

			$query = 'DELETE FROM Noticias WHERE Noticias.id = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}

	}
?>
