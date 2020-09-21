<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">
    <title>Super</title>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>
<div id="app">
    <template v-if="caja==1">
        <div id="caja1">
            <div class="logo">
                <img src="img/logosuper.png" alt="" width="350">
            </div>
            <div class="boton">
                <button @click="caja++">INICIAR MI PEDIDO</button>
            </div>
        </div>
    </template>
    <template v-else-if="caja==2">
        <div id="caja1">
            <div class="logo">
                <img src="img/logosuper.png" alt="" width="50">
                <form action="" id="formulario" @submit.prevent="caja++">
                    <input type="text" placeholder="Celular">
                    <input type="text" placeholder="Nombre">
                    <input type="text" placeholder="Direccion">
                    <input type="date" placeholder="Fecha de nacimiento">
                    <button type="submit" >INICIAR MI PEDIDO</button>
                </form>
            </div>
        </div>
    </template>
    <template v-else-if="caja==3">
        <div id="caja3">
            <p class="title-sucursal">SELECCIONE SU SUCURSAL PREFERIDA</p>
            <div v-for="item in sucursales">
                <div class="content-sucursal" @click="elegirsucursal(item)">
                    <label>{{item.nombre}}</label>
                    <p>{{item.direccion}}</p>
                </div>
            </div>
        </div>
    </template>
    <template v-else-if="caja==4">
        <div id="caja4">
            <p v-for="(item,index) in grupos" @click="elegirgrupo(item)" :key="index" v-bind:class="index%2==0?'grupo1':'grupo2'" >{{item.Descripcion}}</p>
        </div>
    </template>
    <template v-else-if="caja==5">
        <div id="caja5">
            <div class="menu">
                <label @click="caja=3">INICIO</label>
                <label @click="caja=4">SECCIONES</label>
                <label  @click="caja=6" >MI PEDIDO <small class="pedidos">{{pedidos.length}}</small></label>
            </div>
            <center>
                <p class="title-sucursal">{{grupo.Descripcion}}</p>
                <div v-for="(item,index) in productos" :key="index"  class=" accordion "  >
                    <div style="background: red;border: 0px;margin: 0px;padding: 0px" class="card">
                        <div  style="background: red;border: 0px;margin: 0px;padding: 0px" class="card-header" id="headingTwo">
<!--                            <h2 class="mb-0">-->
                                <button   v-bind:style="{background: '#ccc url(img/grupos/'+item.CodAut+'.jpg) no-repeat center center '}" style="width: 100%;border: 0px;margin: 0px;padding: 25px" class="btn text-center text-white btn-link btn-block text-left collapsed " type="button"
                                        data-toggle="collapse" v-bind:data-target="'#ab'+item.CodAut" aria-expanded="false">
                                    {{item.Producto}}
                                </button>
<!--                            </h2>-->
                        </div>
                        <div v-bind:id="'ab'+item.CodAut" class="collapse" >
                            <div class="card-body" @click="getcom(item)">
                                {{item.Producto}} <small class="precio">{{item.Precio|currency}} Bs</small>
                                <div>{{item.descripcion}}</div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="card">-->
<!--                        <div class="card-header" id="headingThree">-->
<!--                            <h2 class="mb-0">-->
<!--                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">-->
<!--                                    Collapsible Group Item #3-->
<!--                                </button>-->
<!--                            </h2>-->
<!--                        </div>-->
<!--                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">-->
<!--                            <div class="card-body">-->
<!--                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
<!--                <p v-for="(item,index) in productos" :key="index" v-bind:style="{background: '#ccc url(img/grupos/'+item.CodAut+'.jpg) no-repeat center center'}"  class="produ" >{{item.Producto}}</p>-->
            </center>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="pedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " style="width: 100%;text-align: center" id="exampleModalLabel">{{producto.Producto}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="agregarpedido()">
                            <center>
                            <div class="form-group row">
                                <label for="cantidad" class="col-6 col-form-label"><div style="background: #F2E402;border-radius: 1em">Cantidad:</div></label>
                                <div class="col-6" id="cantidad">
<!--                                    <input type="text" class="form-control" id="inputPassword">-->
                                    <select class="form-control" v-model="cantidad">
                                        <option v-for="i in cantidades" v-bind:value="i">{{i}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="precio" class="col-6 col-form-label" ><div style="background: #F2E402;border-radius: 1em">Precio:</div></label>
                                <div class="col-6">
                                    <input type="text" class="form-control" disabled id="precio" v-bind:value="parseFloat(producto.Precio)+' Bs.'">
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="precio" class="col-6 col-form-label" ><div style="background: #F2E402;border-radius: 1em">Subtotal:</div></label>
                                    <div class="col-6">
                                        <input type="text" class="form-control" disabled id="precio" v-bind:value="parseFloat(producto.Precio*cantidad).toFixed(2)+' Bs.'">
                                    </div>
                                </div>
                                <div v-if="varios.length!=0" cols="12" sm="12" style="margin: 0px;padding: 0px;border: 0px">
                                    <h6 style="background: #F2E402;border-radius: 1em">Este producto contiene:</h6>
                                        <p v-for="item in varios" style="margin: 0px;padding: 0px;border: 0px">
                                            - {{item.Producto}}
                                        </p>
                                </div>
                                <div v-if="bebidas.length!=0" cols="12" sm="12" style="margin: 0px;padding: 0px;border: 0px">
                                    <h6 style="background: #F2E402;border-radius: 1em">Elige tu(s) bebidas:</h6>
                                    <div style="font-size: 10px" v-if="parseFloat(cantidad)!=1 && parseFloat(totalbebidas)<parseFloat(cantidad)" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        Deves selecionar {{cantidad}}, bebidas selecionadas {{totalbebidas}}
                                    </div>
                                    <div style="font-size: 10px" v-else-if="parseFloat(totalbebidas)>parseFloat(cantidad)" class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Seleciono {{totalbebidas}}  bebidas y deve seleccionar  {{cantidad}}
                                    </div>
                                    <div style="font-size: 10px" v-else-if="parseFloat(totalbebidas)==parseFloat(cantidad)" class="alert alert-success alert-dismissible fade show" role="alert">
                                        Selecionado corretamente
                                    </div>
<!--                                    <v-alert v-if="parseFloat(cantidad)!=1 && parseFloat(totalbebidas)<parseFloat(cantidad)" type="info" style="margin: 0px;padding: 0px;border: 0px">-->
<!--                                        Deves selecionar {{cantidad}}, bebidas selecionadas {{totalbebidas}}-->
<!--                                    </v-alert>-->
<!--                                    <v-alert v-else-if="parseFloat(totalbebidas)>parseFloat(cantidad)" type="warning" style="margin: 0px;padding: 0px;border: 0px">-->
<!--                                        Seleciono {{totalbebidas}}  bebidas y deve seleccionar  {{cantidad}}-->
<!--                                    </v-alert>-->
<!--                                    <v-alert v-else-if="parseFloat(totalbebidas)==parseFloat(cantidad)" type="success" style="margin: 0px;padding: 0px;border: 0px">-->
<!--                                        Selecionado corretamente-->
<!--                                    </v-alert>-->

                                    <p v-for="item in bebidas" style="margin: 0px;padding: 0px;border: 0px;text-align: left;font-size: 11px">
                                        <input v-if="cantidad==1" v-model="item.cantidad" @click="selectagre(item)" type="radio" name="bebidas" required>
                                        <select v-else v-model="item.cantidad" style="border:1px solid #4F5155;width: 35px;border-radius: 2px">
                                            <option value="0">0</option>
                                            <option v-for="i in cantidad" :value="i">{{i}}</option>
                                        </select>
                                        {{item.Producto}}
                                    </p>
                                </div>
                                <div v-if="agregados.length!=0" cols="12" sm="12" style="margin: 0px;padding: 0px;border: 0px;">
                                    <h6 style="background: #F2E402;border-radius: 1em">Agregar:</h6>
                                    <div style="font-size: 10px" v-if="parseFloat(cantidad)!=1 && parseFloat(totalagregados)<parseFloat(cantidad)" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        Deves selecionar {{cantidad}}, bebidas selecionadas {{totalagregados}}
                                    </div>
                                    <div style="font-size: 10px" v-else-if="parseFloat(totalagregados)>parseFloat(cantidad)" class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Seleciono {{totalagregados}}  bebidas y deve seleccionar  {{cantidad}}
                                    </div>
                                    <div style="font-size: 10px" v-else-if="parseFloat(totalagregados)==parseFloat(cantidad)" class="alert alert-success alert-dismissible fade show" role="alert">
                                        Selecionado corretamente
                                    </div>
                                    <p v-for="item in agregados" style="margin: 0px;padding: 0px;border: 0px;text-align: left;font-size: 11px">
                                        <input v-if="cantidad==1" v-model="item.cantidad" @click="selectagre(item)" type="radio" name="agregados" required>
                                        <select v-else v-model="item.cantidad" style="border:1px solid #4F5155;width: 35px;border-radius: 2px">
                                            <option value="0">0</option>
                                            <option v-for="i in cantidad" :value="i">{{i}}</option>
                                        </select>
                                        {{item.Producto}}
                                    </p>
                                </div>
                                <button type="button" class="btn btn-block btn-danger" data-dismiss="modal" style="border-radius: 1em">CANCELAR</button>
                                <button type="submit" class="btn btn-block" style="background: #F2E402;border-radius: 1em">AGREGAR A MI PEDIDO</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </template>
    <template v-else-if="caja==6">
        <div id="caja6">
            <div class="menu">
                <label @click="caja=3">INICIO</label>
                <label @click="caja=4">SECCIONES</label>
                <label  @click="caja=6" >MI PEDIDO <small class="pedidos">{{pedidos.length}}</small></label>
            </div>
        </div>
    </template>
</div>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Hola Vue!',
            caja:5,
            cantidad:1,
            sucursales:[],
            grupos:[],
            productos:[],
            producto:{},
            sucursal:{},
            grupo:{},
            varios:[],
            bebidas:[],
            agregados:[],
            cantidades:[],
            pedidos:[]
        },
        created(){
            for (let i=1;i<=100;i++){
                this.cantidades.push(i);
            }

            axios.get('Welcome/sucursales').then(res=>{
                this.sucursales=res.data;
            })
            axios.get('Welcome/getgrupos').then(res=>{
                this.grupos=res.data;
                // console.log(this.grupos);
            })

            this.grupo={Cod_grup: "CO011     ",
                Descripcion: "HAMBURGUESAS                                     ",
                codAut: "25"};
            axios.get('Welcome/getproductos/CO011     ').then(res=>{
                this.productos=res.data;
                // console.log(this.productos);
                // this.productos.forEach(r=>{
                //     console.log(r.CodAut);
                // })
            })

        },
        methods:{
            selectagre(item){
                // console.log(item);
                this.agregados.forEach(r=>{
                    r.cantidad="0";
                })
            },
            agregarpedido(){
                // console.log(this.producto);
                let det=[];
                this.bebidas.forEach(r=>{
                    // console.log(r);
                    if (r.cantidad==null){
                        // console.log(r);
                        det.push(r);
                    }else
                    if (parseInt(r.cantidad)>0){
                        det.push(r);
                    }
                });
                this.agregados.forEach(r=>{
                    if (r.cantidad==null){
                        det.push(r);
                    }else
                    if (parseInt(r.cantidad)>0){
                        det.push(r);
                    }
                });
                // console.log(this.producto);
                this.pedidos.push({
                    imagen: this.producto.cod_grup,
                    producto: this.producto.Producto,
                    idproducto: this.producto.CodAut,
                    cantidad: this.cantidad,
                    detalle: det,
                    precio: parseFloat(this.producto.Precio) ,
                    subtotal: this.cantidad * this.producto.Precio
                })
                $('#pedido').modal('hide');
            },
            elegirsucursal(suc){
                this.sucursal=suc;
                // this.selectsucursal=false;
                // this.tienda= L.latLng(suc.lat, suc.lng);
                this.caja++;
            },
            elegirgrupo(item){
                this.caja++;
                this.grupo=item;
                axios.get('Welcome/getproductos/'+item.Cod_grup).then(res=>{
                    this.productos=res.data;
                    // console.log(this.productos);
                })
            },
            getcom(item){
                console.log('aaa')
                this.varios=[];
                this.bebidas=[];
                this.agregados=[]
                axios.get('Welcome/getcom/'+item.cod_prod).then(res=>{
                    // console.log(item);
                    this.producto=item;
                    this.cantidad=1;
                    // this.selectpedido=true;
                    $('#pedido').modal('show');

                    if (res.data.length==0){
                        // this.pedidos.push(item);
                        // console.log('no hay composicion');
                        // this.compocicion=[];
                        // this.compocicion="";
                        this.varios=[];
                        this.bebidas=[];
                        this.agregados=[];
                    }else{
                        res.data.forEach(r=>{
                            // console.log(r);
                            if (r.Tipo=='XJO'){
                                this.varios.push(r);
                            }else if (r.Tipo=='BEB'){
                                this.bebidas.push(r);
                            }else if (r.Tipo=='AGR'){
                                this.agregados.push(r);
                            }
                        })
                        // console.log(res.data);
                        // this.compocicion=res.data;

                        // console.log(res.data)
                    }
                    // this.productos=res.data;
                    // console.log(this.productos)
                })
            },
        },
        filters: {
            currency(amount) {
                const amt = Number(amount)
                return amt && amt.toLocaleString(undefined, {maximumFractionDigits:2}) || '0'
            }
        },
        computed:{
            totalbebidas:function (){
                let t=0;
                this.bebidas.forEach(res=>{
                    t+= parseFloat(res.cantidad);
                })
                return t;
            },
            totalagregados:function (){
                let t=0;
                this.agregados.forEach(res=>{
                    t+= parseFloat(res.cantidad);
                })
                return t;
            },
        }

    })
</script>
</body>
</html>
