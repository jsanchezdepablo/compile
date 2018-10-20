/*************************************************CLASE TRANSFORMACIONES*******************************************/
  class Ttransf extends Tentidad{
      constructor(){
          super();
          this.matrix = mat4.identity(mat4.create()); 
      }

      degToRad(d) {
          return d * Math.PI / 180;
      }

      getMatrix(){
          return this.matrix;
      }

      rota(v){
          mat4.rotate(this.matrix, this.degToRad(v[0]), [1, 0, 0]);
          mat4.rotate(this.matrix, this.degToRad(v[1]), [0, 1, 0]);
          mat4.rotate(this.matrix, this.degToRad(v[2]), [0, 0, 1]);
      }

      escala(v){
          mat4.scale(this.matrix, v);
      }

      traslada(v){
          mat4.translate(this.matrix, v);
      }

      beginDraw(){
          var aux = mat4.create();
          mat4.set(modelMatrix, aux);
          apila(aux);          
          mat4.multiply(aux, this.matrix, modelMatrix);
      }

      endDraw(){
          mat4.set(pilaMatrix[pilaMatrix.length - 1], modelMatrix);
          desapila();
      }
  }