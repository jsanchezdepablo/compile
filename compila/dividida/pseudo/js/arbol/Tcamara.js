/*************************************************CLASE CAMARA*******************************************/
  class Tcamara extends Tentidad{
      constructor(esc){
          super();
          this.esc = esc;

          this.matrix = mat4.create();
          this.matrix = mat4.identity(this.matrix);
          this.main = false;
          this.perspectiva = mat4.create();

          this.setPerspective(45, 0.1, 100.0);
      }
      getEscena(){
          return this.esc;
      }

      setMatrix(m){
          this.matrix = m;
      }

      getMatrix(){
          return this.matrix;
      }

      setPerspective(angle, near, far){
          mat4.perspective(angle, gl.viewportWidth / gl.viewportHeight, near, far, this.perspectiva);
      }

      getPerspective(){
          return this.perspectiva;
      }

      changeMain(){
          if(this.main){
              this.main = false;
          }else{
              this.main = true;
          }
      }

      getMain(){
          return this.main;
      }

      beginDraw(){}

      endDraw(){}
  }
