/*************************************************CLASE LUZ*******************************************/
  class Tluz extends Tentidad{
      constructor(esc){
          super();
          this.esc = esc;
          
          this.intensidadDifusa = [1.0, 1.0, 1.0];
          this.intensidadEspecular = [0.0, 0.0, 0.0];
          this.direccion = null;
          this.conusAngle = 0.5;

          this.matrix = mat4.create();
          this.matrix = mat4.identity(this.matrix);
      }
      getMiEscena(){
          return this.esc;
      }

      setIntensidadDifusa(fx, fy, fz){  
          this.intensidadDifusa = [fx, fy, fz];
      }
      getIntensidadDifusa(){
          return this.intensidadDifusa;
      }

      setIntensidadEspecular(fx, fy, fz){  
          this.intensidadEspecular = [fx, fy, fz];
      }
      getIntensidadEspecular(){
          return this.intensidadEspecular;
      }

      getDireccion(){
          return this.direccion;
      }
      setDireccion(fx, fy, fz){
          this.direccion = [fx, fy, fz];
      }

      getConusAngle(){
          return this.conusAngle;
      }
      setConusAngle(angle){
          //PASAMOS A RADIANES
          angle = angle * Math.PI / 180;
          //CALCULAMOS EL COSENO
          this.conusAngle = Math.cos(angle);
      }

      beginDraw(){};

      endDraw(){};
  }