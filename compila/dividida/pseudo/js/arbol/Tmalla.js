/*************************************************CLASE MALLA*******************************************/
  class Tmalla extends Tentidad{
      constructor(esc, nombreRecurso, nombreTextura){
          super();
          this.esc = esc;

          this.nombreRecurso = nombreRecurso;
          this.malla = null;

          this.nombreTextura = nombreTextura;
          this.textura = null;

          this.shininess = 32.0;
          this.pMalla = [];
      }

      getPMalla(){
          return this.pMalla;
      }

      setTextura(){
          this.textura = gestorRecursos.getRecursoTextura(this.nombreTextura);
      } 
      //AQUI NOS COMUNICAMOS CON EL GESTOR DE RECURSOS Y ESTE NOS DEVUELVE LA MALLA PARSEADA
      cargar(){
          this.malla = gestorRecursos.getRecurso(this.nombreRecurso);
      }

      //PARA INICIALIZAR LAS MATRICES EN EL SHADER
      setMatrixUniforms(){
          // console.log("NOMBRE MALLA: " + this.malla.getNombre());
          //CREO LA MATRIZ MODEL VIEW MULTIPLICANDO LAS MATRICES MODEL Y VIEW Y LAS ANYADO AL SHADER
          var aux = mat4.create();
          aux = mat4.set(viewMatrix, aux);
          this.pMalla = [
                          modelMatrix[0], modelMatrix[1], modelMatrix[2], modelMatrix[3], 
                          modelMatrix[4], modelMatrix[5], modelMatrix[6], modelMatrix[7],
                          modelMatrix[8], modelMatrix[9], modelMatrix[10], modelMatrix[11],
                          modelMatrix[12], modelMatrix[13], modelMatrix[14], modelMatrix[15]
                        ];
          // console.log(this.pMalla);
          var TMVmatrix = mat4.multiply(aux, modelMatrix, TMVmatrix);
          gl.uniformMatrix4fv(shaderProgram.mvMatrixUniform, false, TMVmatrix);
          gl.uniformMatrix4fv(shaderProgram.pMatrixUniform, false, pMatrix);
          
          //AQUI CREO LA MATRIZ DE LAS NORMALES, QUE ES BASICAMENTE LA INVERSA DE AL TRASPUESTA DE LA MODELVIEWMATRIX
          var normalMatrix = mat3.create();
          mat4.toInverseMat3(TMVmatrix, normalMatrix);
          mat3.transpose(normalMatrix);
          gl.uniformMatrix3fv(shaderProgram.nMatrixUniform, false, normalMatrix);
      }  

      beginDraw(){
          if(this.malla == null){
              return;
          }
          // console.log("draw malla ****************************")
          var bufferPosicion = this.malla.getMeshVertexPositionBuffer();
          var bufferTextura = this.malla.getMeshVertexTextureCoordBuffer();
          var bufferNormales = this.malla.getMeshVertexNormalBuffer();
          var bufferIndices = this.malla.getMeshVertexIndexBuffer();
          //COMPRUEBO QUE SE HAYA INICIALIZADO LA MALLA
          // console.log("recurso: " + this.malla);
          // console.log("BufferPosiciones: " + bufferPosicion);
          // console.log("BufferNormales: " + bufferNormales);
          // console.log("textura: " + bufferTextura);
          // console.log("indices: " + bufferIndices);
          
          if (bufferPosicion == null || bufferNormales == null || bufferTextura == null || bufferIndices == null) {
              // console.log("**********************************");
              return;
          }
          gl.uniform1f(shaderProgram.materialShininessUniform, this.shininess);
          var ok = true;
          if(this.esc.getLuces() != null && this.esc.getLuces().length > 0 && ok){
              gl.uniform1i(shaderProgram.useLightingUniform, true);
              //VALOR DE LA LUZ AMBIENTAL
              gl.uniform3fv(shaderProgram.ambientColorUniform, this.esc.getAmbiental());

              var arrayLucesDireccionales = [];
              
              var arrayLucesPuntuales = [];
              var nlp = 0;
              var nld = 0;
              
              for(var i=0; i<this.esc.getLuces().length; i++){
                  if(this.esc.getLuces()[i].getEntidad().getDireccion() != null){
                      arrayLucesDireccionales.push(this.esc.getLightMatrix()[i][0]);
                      arrayLucesDireccionales.push(this.esc.getLightMatrix()[i][1]);
                      arrayLucesDireccionales.push(this.esc.getLightMatrix()[i][2]);

                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getIntensidadDifusa()[0]);
                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getIntensidadDifusa()[1]);
                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getIntensidadDifusa()[2]);

                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getIntensidadEspecular()[0]);
                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getIntensidadEspecular()[1]);
                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getIntensidadEspecular()[2]);

                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getDireccion()[0]);
                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getDireccion()[1]);
                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getDireccion()[2]);

                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getConusAngle()[0]);
                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getConusAngle()[1]);
                      arrayLucesDireccionales.push(this.esc.getLuces()[i].getEntidad().getConusAngle()[2]);

                      nld++;
                  }else{
                      arrayLucesPuntuales.push(this.esc.getLightMatrix()[i][0]);
                      arrayLucesPuntuales.push(this.esc.getLightMatrix()[i][1]);
                      arrayLucesPuntuales.push(this.esc.getLightMatrix()[i][2]);

                      arrayLucesPuntuales.push(this.esc.getLuces()[i].getEntidad().getIntensidadDifusa()[0]);
                      arrayLucesPuntuales.push(this.esc.getLuces()[i].getEntidad().getIntensidadDifusa()[1]);
                      arrayLucesPuntuales.push(this.esc.getLuces()[i].getEntidad().getIntensidadDifusa()[2]);

                      arrayLucesPuntuales.push(this.esc.getLuces()[i].getEntidad().getIntensidadEspecular()[0]);
                      arrayLucesPuntuales.push(this.esc.getLuces()[i].getEntidad().getIntensidadEspecular()[1]);
                      arrayLucesPuntuales.push(this.esc.getLuces()[i].getEntidad().getIntensidadEspecular()[2]);

                      nlp++;
                  }
              }
              //LUCES DIRECCIONALES
              gl.uniform1i(shaderProgram.nDireccionalLightsUniform, nld);
              if(nld > 0){
                  var aux = arrayLucesDireccionales.length % 3;

                  for(var i=0; i<aux; i++){
                      arrayLucesDireccionales.push(0.0);
                  }
                  gl.uniform3fv(shaderProgram.sceneDirectionalLightsUniform, arrayLucesDireccionales);
              }
              
              //LUCES PUNTUALES
              gl.uniform1i(shaderProgram.nLightsUniform, nlp);
              if(nlp > 0){
                  gl.uniform1fv(shaderProgram.scenePointLightsUniform, arrayLucesPuntuales);
              }
          }else{
              gl.uniform1i(shaderProgram.useLightingUniform, false);
          }

          
          if(this.textura.getTextureMesh() != null){
              gl.uniform1i(shaderProgram.useTexturesUniform, true);
              //LE INDICO AL SHADER QUE TEXTURA VAMOS A UTILIZAR
              gl.activeTexture(gl.TEXTURE0);
              gl.bindTexture(gl.TEXTURE_2D, this.textura.getTextureMesh());

              gl.uniform1i(shaderProgram.samplerUniform, 0);
          }else{
              gl.uniform1i(shaderProgram.useTexturesUniform, false);
          }

          //AQUI LE PASO LOS BUFFER AL SHADER
          gl.bindBuffer(gl.ARRAY_BUFFER, bufferPosicion);
          gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, bufferPosicion.itemSize, gl.FLOAT, false, 0, 0);

          gl.bindBuffer(gl.ARRAY_BUFFER, bufferTextura);
          gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, bufferTextura.itemSize, gl.FLOAT, false, 0, 0);

          gl.bindBuffer(gl.ARRAY_BUFFER, bufferNormales);
          gl.vertexAttribPointer(shaderProgram.vertexNormalAttribute, bufferNormales.itemSize, gl.FLOAT, false, 0, 0);

          gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, bufferIndices);

          //Y AQUI FINALMENTE INVOCO AL METODO QUE INICIALIZA LAS MATRICES MODEL VIEW Y LA DE LAS NORMALES
          this.setMatrixUniforms();
          //INVOCO AL DRAW ELEMENTS PARA QUE PINTE LA MALLA
          gl.drawElements(gl.TRIANGLES, bufferIndices.numItems, gl.UNSIGNED_SHORT, 0);
          // console.log("**********************************");
      }

      endDraw(){}
  }
