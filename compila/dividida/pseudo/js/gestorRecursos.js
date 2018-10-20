class TGestorRecursos {
	constructor(){
		this.recursosMalla = null;
		this.recursosTextura = null;
	}

	getRecurso(r) {
		var rec = null;
		if(this.recursosMalla == null){
			this.recursosMalla = [];
		}
		if(r != null){
			for(var i=0; i<this.recursosMalla.length; i++){
				if(this.recursosMalla[i] != null && this.recursosMalla[i].getNombre() != null && 
					this.recursosMalla[i].getNombre().localeCompare(r) == 0){

					rec = this.recursosMalla[i];
					break;
				}
			}
			if(rec == null){
				rec = new TRecursoMalla(r);
				rec.cargarFichero(r);
				this.recursosMalla.push(rec);
			}
		}
		return rec;
	}

	getRecursoTextura(t){
		var rec = null;
		if(this.recursosTextura == null){
			this.recursosTextura = [];
		}
		if(t != null){
			for(var i=0; i<this.recursosTextura.length; i++){
				if(this.recursosTextura[i] != null && this.recursosTextura[i].getNombreT() != null &&
				 this.recursosTextura[i].getNombreT().localeCompare(t) == 0){

					rec = this.recursosTextura[i];
					break;
				}
			}
			if(rec == null){
				rec = new TRecursoTextura(t);
				rec.setTexture(t);
				this.recursosTextura.push(rec);
			}
		}
		return rec;
	}
}

class TRecursoMalla {
	constructor(nombre){
		this.nombre = nombre;
		this.meshVertexTextureCoordBuffer = null;
		this.meshVertexPositionBuffer = null;
		this.meshVertexNormalBuffer = null;
		this.meshVertexIndexBuffer = null;
	}

	getMeshVertexPositionBuffer(){
		return this.meshVertexPositionBuffer;
	}
	getMeshVertexNormalBuffer(){
		return this.meshVertexNormalBuffer;
	}
	getMeshVertexIndexBuffer(){
		return this.meshVertexIndexBuffer;
	}
	getMeshVertexTextureCoordBuffer(){
		return this.meshVertexTextureCoordBuffer;
	}

	getNombre(){
		return this.nombre; 
	}

	setNombre(n){
		if(n != null){
			this.nombre = n;
		} 
	}

	cargarFichero(nf){
		if(nf != null){
			var request = new XMLHttpRequest();
	        request.open("GET", nf);
	        var auxGestor = this;
	        request.onreadystatechange = function () {
	            if (request.readyState == 4) {
	                auxGestor.handleLoadedMesh(JSON.parse(request.responseText));
	            }
	        }
	        request.send();
		}
	}

	handleLoadedMesh(rt){
		this.meshVertexNormalBuffer = gl.createBuffer();
		gl.bindBuffer(gl.ARRAY_BUFFER, this.meshVertexNormalBuffer);
		gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(rt.vertexNormals), gl.STATIC_DRAW);
	    this.meshVertexNormalBuffer.itemSize = 3;
	    this.meshVertexNormalBuffer.numItems = rt.vertexNormals.length / 3;

	    this.meshVertexPositionBuffer = gl.createBuffer();
	    gl.bindBuffer(gl.ARRAY_BUFFER, this.meshVertexPositionBuffer);
	    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(rt.vertexPositions), gl.STATIC_DRAW);
	    this.meshVertexPositionBuffer.itemSize = 3;
	    this.meshVertexPositionBuffer.numItems = rt.vertexPositions.length / 3;

	    this.meshVertexIndexBuffer = gl.createBuffer();
	    gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, this.meshVertexIndexBuffer);
	    gl.bufferData(gl.ELEMENT_ARRAY_BUFFER, new Uint16Array(rt.indices), gl.STATIC_DRAW);
	    this.meshVertexIndexBuffer.itemSize = 1;
	    this.meshVertexIndexBuffer.numItems = rt.indices.length;

	    this.meshVertexTextureCoordBuffer = gl.createBuffer();
	    gl.bindBuffer(gl.ARRAY_BUFFER, this.meshVertexTextureCoordBuffer);
	    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(rt.vertexTextureCoords), gl.STATIC_DRAW);
	    this.meshVertexTextureCoordBuffer.itemSize = 2;
	    this.meshVertexTextureCoordBuffer.numItems = rt.vertexTextureCoords.length / 2;
	}
}

class TRecursoTextura{
	constructor(nombreT){
		this.texture = null;
		this.nombreT = nombreT;
	}
	setNombreT(n){
		this.nombreT = n;
	}
	getNombreT(){
		return this.nombreT;
	}

	getTextureMesh(){
		return this.texture;
	}

	//ESTO METODO CARGA LA TEXTURA POR FICHERO, DE ESTA FORMA PODEMOS CAMBIAR LA TEXTURA DE UN RECURSO DESDE EL PROPIO MOTOR
	setTexture(file){
		this.texture = gl.createTexture();
        this.texture.image = new Image();
        var auxRecurso = this;
        this.texture.image.onload = function () {
            auxRecurso.handleLoadedTexture()
        }
        this.texture.image.src = file;
	}

	handleLoadedTexture(){
		gl.pixelStorei(gl.UNPACK_FLIP_Y_WEBGL, true);
        gl.bindTexture(gl.TEXTURE_2D, this.texture);
        gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, this.texture.image);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR_MIPMAP_NEAREST);
        gl.generateMipmap(gl.TEXTURE_2D);

        gl.bindTexture(gl.TEXTURE_2D, null);
	}
}

class TRecursoMaterial{}
