<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>Super!</title>
</head>
<body>
<div class="container" id="app">
    <div class="row" v-if="caja==1">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card  mt-3">
                <div class="card-header text-white bg-dark" >login</div>
                <div class="card-body">
                    <h5 class="card-title">Ingreso al Sistema</h5>
                    <p class="card-text">
                    <form @submit.prevent="login">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" v-model="user.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" v-model="user.password"  class="form-control" id="exampleInputPassword1" autocomplete="on" required>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox"  class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block"><i class="fa fa-save"></i> Ingresar</button>
                    </form>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row" v-if="caja==2">
        <div class="col-md-12">
            <table class="table mt-2">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Opciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(i,index) in products" :key="index">
                    <th scope="row">{{index+1}}</th>
                    <td>{{i.Producto}}</td>
                    <td>{{i.descripcion}}</td>
                    <td><a v-if="i.img!=''" target="_blank"  :href="i.img">Imagen</a></td>
                    <td>
                        <button @click="img(i)" class="btn btn-sm btn-warning p-1" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-eye"></i></button>
                        <button @click="img(i)" class="btn btn-sm btn-info p-1" data-toggle="modal" data-target="#modificar"> <i class="fa fa-pencil"></i></button>
                    </td>
                </tr>
<!--                <tr>-->
<!--                    <th scope="row">2</th>-->
<!--                    <td>Jacob</td>-->
<!--                    <td>Thornton</td>-->
<!--                    <td>@fat</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <th scope="row">3</th>-->
<!--                    <td>Larry</td>-->
<!--                    <td>the Bird</td>-->
<!--                    <td>@twitter</td>-->
<!--                </tr>-->
                </tbody>
            </table>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{product.Producto}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action=""  @submit.prevent="updateAvatar">
                            <div class="modal-body">
                                <input type="file" name="image" @change="getImage" accept="image/*" required>
<!--                                <button>Subir Imagen</button>-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-trash"></i>Cancelar</button>
                                <button type="submit" :disabled="d1" class="btn btn-success"> <i class="fa fa-save"></i> Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modificar" tabindex="-1" aria-labelledby="examplemodificar" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="examplemodificar">{{product.Producto}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form  @submit.prevent="actualizar">
                            <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="Nombre" v-model="product.Producto">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Descripcion" class="col-sm-2 col-form-label">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="Descripcion" v-model="product.descripcion">
                                        </div>
                                    </div>                           <!--                                <button>Subir Imagen</button>-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-trash"></i>Cancelar</button>
                                <button type="submit" :disabled="d2" class="btn btn-success"> <i class="fa fa-save"></i> Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js" integrity="sha512-DZqqY3PiOvTP9HkjIWgjO6ouCbq+dxqWoJZ/Q+zPYNHmlnI2dQnbJ5bxAHpAMw+LXRm4D72EIRXzvcHQtE8/VQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            user: {},
            caja:2,
            products:[],
            product:{},
            imagen : null,
            d1:false,
            d2:false,
        },
        mounted(){
            axios.get('Admin/productos').then(res=>{
                // console.log(res.data);
                this.products=res.data;
            })
        },
        methods:{
            login(){
                axios.post('Admin/login',this.user).then(res=>{
                    // console.log(res.data);
                    if (res.data=='SI'){
                        this.caja=2;
                    }
                })
            },
            getImage(event){
                //Asignamos la imagen a  nuestra data
                this.imagen = event.target.files[0];
            },
            updateAvatar(){
                //Creamos el formData
                var data = new  FormData();
                //Añadimos la imagen seleccionada
                console.log(this.product.CodAut)
                data.append('uploadedfile', this.imagen);
                // data.append('id', this.product.CodAut);
                //Añadimos el método PUT dentro del formData
                // Como lo hacíamos desde un formulario simple _(no ajax)_
                // data.append('_method', 'PUT');
                //Enviamos la petición
                this.d1=true;
                axios.post('Admin/modificar/'+this.product.CodAut,data).then(res => {
                    // console.log(res.data);
                    const index=this.products.findIndex(item=>item.CodAut===res.data.CodAut);
                    this.products[index]=res.data;
                    $('#exampleModal').modal('hide');
                    this.d1=false;
                })
            },
            img(i){
                this.product=i;
            },
            actualizar(){
                // console.log('a');
                this.d2=true;
                axios.post('Admin/actualizar',this.product).then(res => {
                    // console.log(res.data);
                    const index=this.products.findIndex(item=>item.CodAut===res.data.CodAut);
                    this.products[index]=res.data;
                    $('#modificar').modal('hide');
                    this.d2=false;
                })
            }
        }
    })
</script>
</body>
</html>
