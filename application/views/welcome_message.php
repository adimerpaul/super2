<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css" />
</head>
<body>
<div id="app">
    <v-app id="inspire">
        <v-app id="inspire">
            <v-app-bar
                    :clipped-left="$vuetify.breakpoint.lgAndUp"
                    app
                    color="blue darken-3"
                    dark
            >
                <v-toolbar-title
                        style="width: 300px"
                        class="ml-0 pl-4"
                >
                    <v-list-item >
                        <v-list-item-avatar>
                            <img src="<?=base_url()?>img/logo.png">
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title >{{sucursal.nombre}}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon>
                    <v-icon>mdi-apps</v-icon>
                </v-btn>

                <div v-if="isusuario.Nombres">
                    <v-btn small color="primary">{{isusuario.Nombres.substring(0,5)}}</v-btn>
                    <v-btn small color="error" @click="salir">Salir</v-btn>
                </div>
                <div v-else>
                    <v-btn small color="primary" @click="logindialog=true">Ingresar</v-btn>
                    <v-btn small color="primary" @click="dialog=!dialog">Registrar</v-btn>

                </div>
            </v-app-bar>
            <v-main>
                <v-container fluid>
                    <v-row  >
                        <v-col v-if="pedidodialog==false" cols="12" sm="6" md="6">
                            <v-row >
                                <v-card style="width: 100%">
                                    <v-list two-line >
                                        <template >
                                            <v-subheader >Productos</v-subheader>
                                            <v-list-item v-for="(item, index) in pedidos" :key="index" >
                                                <v-list-item-avatar>
                                                    <img  v-bind:src="'img/grupos/'+item.imagen+'.jpg'">
                                                </v-list-item-avatar>
                                                <v-list-item-content>
                                                    <v-list-item-title >
                                                        <v-row>
                                                            <v-col cols="9">{{item.producto}}</v-col>
                                                            <v-col  cols="3" aling="center" style="text-align: right">
                                                                <v-btn small color="error" @click="elipedido(index)"><i class="fa fa-trash"></i></v-btn>
                                                            </v-col>
                                                        </v-row>
                                                    </v-list-item-title>
                                                    <v-list-item-subtitle  style="text-align: right">
                                                        <v-row>
                                                            <v-col cols="6" aling="center" style="text-align: left">
                                                                <p v-for="i in item.detalle" style="padding: 0px;margin: 0px;border: 0px">
                                                                    <v-badge
                                                                            :content="i.cantidad"
                                                                            :value="i.cantidad"
                                                                            color="green"
                                                                            overlap
                                                                    >
                                                                        {{i.Producto}}
                                                                    </v-badge>
                                                                </p>
                                                            </v-col>
                                                            <v-col  cols="6" aling="center" style="text-align: right">
                                                                <v-btn x-small color="secondary" dark>Cant. {{item.cantidad}}</v-btn> <v-btn x-small color="secondary" dark>Prec. {{item.precio}}</v-btn> <v-btn x-small color="secondary" dark>Subt. {{item.subtotal}}</v-btn>
                                                            </v-col>
                                                        </v-row>

                                                    </v-list-item-subtitle>

                                                </v-list-item-content>
                                            </v-list-item>
                                            <h4 style="text-align: right;padding: 0.5em">TOTAL: {{total}}</h4>
                                            <v-btn @click="pedidodialog=true" block color="success" dark><i class="fa  fa-shopping-cart"></i>Realizar pedido</v-btn>
                                        </template>
                                    </v-list>
                                </v-card>
                            </v-row>
                        </v-col>
                        <v-col v-else cols="12" sm="6" md="6">
                            <v-card style="width: 100%">
                                <v-list two-line >
                                    <template >
                                        <v-subheader>
                                            <v-btn x-small color="error" @click="pedidodialog=false"><i class="fa fa-trash"></i>Cancelar</v-btn>
                                            Seleciona la ubicacion del pedido {{dispedido}} mts
                                            <v-btn v-if="dispedido<1000" x-small color="secondary" dark>Costo envio gratis</v-btn>
                                            <v-btn v-else-if="dispedido<2000" x-small color="secondary" dark>Costo envio 10 Bs.</v-btn>
                                            <v-btn v-else x-small color="secondary" dark>Costo envio 20 Bs.</v-btn>
                                        </v-subheader>
                                    </template>
                                </v-list>
                            </v-card>
                            <l-map :zoom="zoom" :center="center" @click="addMarker">
                                <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                                <l-marker :lat-lng="marker"></l-marker>
                                <l-marker :lat-lng="tienda" :icon="icon" >
                                    <l-popup>
                                        <div >
                                            La tienda se encuentra aca
                                        </div>
                                    </l-popup>
                                </l-marker>
                            </l-map>
                            <v-btn @click="realizarpedido" block color="success" dark><i class="fa  fa-shopping-cart"></i>Terminar  pedido</v-btn>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                            <h3>Grupos <a href="<?=base_url()?>"><h5>Reiniciar</a></h5></h3>
                            <v-row >
                                <div v-for="item in grupos" @click="selectproduct(item.Cod_grup)"
                                     style='color:white;
                                     display:flex;
                                     align-items:center;
                                     text-align:center;
                                     overflow:hidden;
                                     font-size:0.8em;
                                     width: 90px;height: 70px;
                                     border: 1px solid #4F5155;
                                     background-color: black;
                                     background-position: center;
                                     background-repeat: no-repeat;
                                     background-size: cover;
                                     position: relative;'
                                     v-bind:style="{backgroundImage: 'url(img/grupos/' + item.codAut + '.jpg)'}"
                                >
                                    <div  style="text-align: center;width: 100%;background: rgba(0,0,0,0.3)">{{item.Descripcion}}</div>
                                </div>
                            </v-row>
                            <h3>Productos</h3>
                            <v-row >
                                <div v-for="item in productos" @click="getcom(item)"
                                     style='color:white;
                                     display:flex;
                                     align-items:center;
                                     text-align:center;
                                     overflow:hidden;
                                     font-size:0.7em;
                                     width: 90px;height: 70px;
                                     border: 1px solid #4F5155;
                                     background-color: black;
                                     background-position: center;
                                     background-repeat: no-repeat;
                                     background-size: cover;
                                     position: relative;'
                                     v-bind:style="{backgroundImage: 'url(img/grupos/' + item.cod_grup + '.jpg)'}"
                                >
                                    <div style="text-align: center;width: 100%;background: rgba(0,0,0,0.3)">
                                        {{item.Producto}}<br>
                                        {{item.Precio| currency}} Bs.
                                        Stock {{item.Saldo}}
                                    </div>
                                </div>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
            <v-dialog v-model="dialog" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                        <span class="headline">Registrate</span>
                    </v-card-title>
                    <form @submit.prevent="guardar">
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field v-model="usuario.nombre" label="Nombre Completo*" required></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field v-model="usuario.celular" label="Celular*" hint="Ej: 69603027" required></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field v-model="usuario.password" autocomplete type="password" label="Password*" required></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field v-model="usuario.password2" autocomplete type="password" label="Repetir Password*" required></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                        <small>*indicates required field</small>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue" :required="guar" type="submit" >Crear</v-btn>
                        <v-btn color="error"  @click="dialog = false">Cancelar</v-btn>
                    </v-card-actions>
                    </form>
                </v-card>
            </v-dialog>
            <v-dialog v-model="logindialog" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                        <span class="headline">Ingresar</span>
                    </v-card-title>
                    <form @submit.prevent="login">
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-text-field  v-model="usuario.celular" label="Celular*" hint="Ej: 69603027" required></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-text-field v-model="usuario.password" autocomplete type="password" label="Password*" required></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                            <small>*Campo requerido</small>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary"  type="submit" ><i class="fa fa-check"></i>Ingresar</v-btn>
                            <v-btn color="error"  @click="logindialog = false"> <i class="fa fa-trash"></i>Cancelar</v-btn>
                        </v-card-actions>
                    </form>
                </v-card>
            </v-dialog>
            <v-dialog v-model="selectsucursal" persistent max-width="450">
                <v-card>
                    <v-card-title class="headline">Seleccionar sucursal</v-card-title>
                    <v-card-text>
                        <v-card v-for="item in sucursales" v-bind:key="item.idsucursal" class="mx-auto" style="border: 2px solid #4F5155" @click="elegirsucursal(item)">
                            <v-img
                                    class="white--text align-end"
                                    height="120px"
                                    v-bind:src="'img/super'+item.idsucursal+'.jpg'"
                            >
                                <v-card-title style="background: rgba(0,0,0,0.3)">{{item.nombre}}</v-card-title>
                            </v-img>
                        </v-card>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-dialog v-model="selectpedido" persistent max-width="500">
                <v-card >
                    <form @submit.prevent="agregarpedido()">
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline ">Producto <v-btn color="error" @click="selectpedido=!selectpedido" small><i class="fa fa-trash"></i>Cancelar</v-btn></div>
                            <v-list-item-title class="headline mb-1">{{producto.Producto}}</v-list-item-title>

                            <v-list-item-subtitle>
                                <v-row style="margin: 0px;padding: 0px;border: 0px;margin-top: 0.5em">
                                    <v-col cols="12" sm="4" style="margin: 0px;padding: 0px;border: 0px">
                                        <v-select
                                                :items="cantidades"
                                                label="Cantidad"
                                                dense
                                                outlined
                                                width="10"
                                                v-model="cantidad"
                                                @change="reiniciar"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" sm="4" style="margin: 0px;padding: 0px;border: 0px">
                                        <v-select
                                                :items="[producto.Precio]"
                                                label="Precio"
                                                dense
                                                outlined
                                                width="10"
                                                v-model="producto.Precio"
                                        ></v-select>
                                    </v-col>
                                <v-col cols="12" sm="4" style="margin: 0px;padding: 0px;border: 0px">
                                    <v-select
                                            :items="[producto.Precio*cantidad]"
                                            label="Total"
                                            dense
                                            outlined
                                            width="10"
                                            v-model="producto.Precio*cantidad"
                                    ></v-select>
                                </v-col>
                                </v-row>
                                <v-row style="margin: 0px;padding: 0px;border: 0px">
                                    <v-col v-if="varios.length!=0" cols="12" sm="12" style="margin: 0px;padding: 0px;border: 0px">
                                        <fieldset >
                                            <legend>Este producto contiene:</legend>
                                                <p v-for="item in varios" style="margin: 0px;padding: 0px;border: 0px">
                                                    {{item.Producto}}
                                                </p>
                                        </fieldset>
                                    </v-col>
                                    <v-col v-if="bebidas.length!=0" cols="12" sm="6" style="margin: 0px;padding: 0px;border: 0px">
                                        <fieldset>
                                            <legend>Bebidas:</legend>
                                            <v-alert v-if="parseFloat(cantidad)!=1 && parseFloat(totalbebidas)<parseFloat(cantidad)" type="info" style="margin: 0px;padding: 0px;border: 0px">
                                                Deves selecionar {{cantidad}}, bebidas selecionadas {{totalbebidas}}
                                            </v-alert>
                                            <v-alert v-else-if="parseFloat(totalbebidas)>parseFloat(cantidad)" type="warning" style="margin: 0px;padding: 0px;border: 0px">
                                                Seleciono {{totalbebidas}}  bebidas y deve seleccionar  {{cantidad}}
                                            </v-alert>
                                            <v-alert v-else-if="parseFloat(totalbebidas)==parseFloat(cantidad)" type="success" style="margin: 0px;padding: 0px;border: 0px">
                                                Selecionado corretamente
                                            </v-alert>
                                            <p v-for="item in bebidas" style="margin: 0px;padding: 0px;border: 0px">
                                                <input v-if="cantidad==1" v-model="item.cantidad" type="radio" @click="selectcant(item)" name="bebida" required>
                                                <select v-else v-model="item.cantidad" style="border:1px solid #4F5155;width: 2em;border-radius: 2px">
                                                    <option value="0">0</option>
                                                    <option v-for="i in cantidad" :value="i">{{i}}</option>
                                                </select>
                                                {{item.Producto}}
                                            </p>
                                        </fieldset>
                                    </v-col>
                                    <v-col v-if="agregados.length!=0" cols="12" sm="6" style="margin: 0px;padding: 0px;border: 0px">
                                        <fieldset>
                                            <legend>Agregar:</legend>
                                            <v-alert v-if="parseFloat(cantidad)!=1 && parseFloat(totalagregados)<parseFloat(cantidad)" type="info" style="margin: 0px;padding: 0px;border: 0px">
                                                Deves selecionar {{cantidad}},  selecionadas {{totalagregados}}
                                            </v-alert>
                                            <v-alert v-else-if="parseFloat(totalagregados)>parseFloat(cantidad)" type="warning" style="margin: 0px;padding: 0px;border: 0px">
                                                Seleciono {{totalagregados}}  y deve seleccionar  {{cantidad}}
                                            </v-alert>
                                            <v-alert v-else-if="parseFloat(totalagregados)==parseFloat(cantidad)" type="success" style="margin: 0px;padding: 0px;border: 0px">
                                                Selecionado corretamente
                                            </v-alert>
                                            <p v-for="item in agregados" style="margin: 0px;padding: 0px;border: 0px">
                                                <input v-if="cantidad==1" v-model="item.cantidad" @click="selectagre(item)" type="radio" name="agregados" required>
                                                <select v-else v-model="item.cantidad" style="border:1px solid #4F5155;width: 2em;border-radius: 2px">
                                                    <option value="0">0</option>
                                                    <option v-for="i in cantidad" :value="i">{{i}}</option>
                                                </select>
                                                {{item.Producto}}
                                            </p>
                                        </fieldset>

                                    </v-col>
                                </v-row>
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-card-actions>
                        <v-btn color="error" @click="selectpedido=!selectpedido"><i class="fa fa-trash"></i>Cancelar</v-btn>
                        <v-btn type="submit" color="primary" ><i class="fa fa-plus"></i>Agregar</v-btn>
                    </v-card-actions>
                    </form>
                </v-card>
            </v-dialog>
        </v-app>
    </v-app>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue-toastr/dist/vue-toastr.umd.min.js"></script>
<script src="node_modules/leaflet/dist/leaflet.js"></script>
<script src="node_modules/vue2-leaflet/dist/vue2-leaflet.min.js"></script>
<script>
    var { LMap, LTileLayer,LPopup, LMarker,LIcon } = Vue2Leaflet;
    //const { LMap, LTileLayer, LMarker, LTooltip, LPopup } = Vue2Leaflet;

    new Vue({
        el: '#app',
        components: { LMap, LTileLayer, LMarker ,LPopup,LIcon},
        vuetify: new Vuetify(),
        props: {
            source: String,
        },
        mounted() {
            // Inject your class names for animation
            this.$toastr.defaultClassNames = ["animated", "zoomInUp"];
            // Change Toast Position
            this.$toastr.defaultPosition = "toast-top-left";
            // Send message to browser screen
        },
        created(){
            if (localStorage.getItem('Nombres')!=undefined){
                this.isusuario.Nombres=localStorage.getItem('Nombres');
                this.isusuario.id=localStorage.getItem('id');
                this.isusuario.celular=localStorage.getItem('celular');
                // console.log(this.isusuario.Nombres)
            }
            axios.get('Welcome/getgrupos').then(res=>{
                this.grupos=res.data;
                // console.log(this.grupos)
                // res.data.forEach(r=>{
                //     console.log(r.codAut)
                // })
            })
            axios.get('Welcome/sucursales').then(res=>{
                this.sucursales=res.data;
            })
            for (let i=1;i<=100;i++){
                this.cantidades.push(i);
            }
        },
        filters: {
            currency(amount) {
                const amt = Number(amount)
                return amt.toFixed(2);
            }
        },
        methods:{
            addMarker(event) {
                // this.markers.push(event.latlng);
                this.marker= L.latLng(event.latlng);
            },
            selectcant(item){
                // console.log(item);
                this.bebidas.forEach(r=>{
                    r.cantidad="0";
                })
            },
            selectagre(item){
                // console.log(item);
                this.agregados.forEach(r=>{
                    r.cantidad="0";
                })
            },
            async realizarpedido(){
                // this.pedidodialog=true;
                if(this.pedidos.length==0){
                    alert('Debes seleccionar productos para la venta!!!');
                    return false;
                }
                if(!this.isusuario.id){
                    alert('Debes seleccionar ingresar o registrarse');
                    return false;
                }

                let cm=this;
                // console.log(this.usuario);
                let costoenvio=0;
                if (this.dispedido<1000){
                    costoenvio=0;
                }else if (this.dispedido<2000){
                    costoenvio=10;
                }else{
                    costoenvio=20;
                }
                //console.log(this.total);
                //return false;

                await  axios.post('Welcome/pedido',{
                    nombre:this.isusuario.Nombres,
                    idcliente:this.isusuario.id,
                    celular:this.isusuario.celular,
                    lat:this.marker.lat,
                    lng:this.marker.lng,
                    total:this.total,
                    idsucursal:this.sucursal.idsucursal,
                    costoenvio:costoenvio,
                }).then(async res=>{
                    let idpedido=await res.data;
                    // console.log(idpedido);
                    this.pedidos.forEach(async (res)=>{
                        // console.log(res);
                        // console.log(JSON.stringify(res.detalle));
                        let det="";
                        if(res.detalle.length!=0){
                            res.detalle.forEach(async (r)=>{
                                // console.log(r.Producto+' '+r.cantidad);
                                if(r.cantidad==null){
                                    r.cantidad=1;
                                }
                                det+=r.Producto.trim()+' '+r.cantidad+',';
                            });
                        }
                        // console.log(res);
                        await axios.post('Welcome/pedidodetalles',{
                            idproducto:res.idproducto,
                            producto:res.producto.trim(),
                            precio:res.precio,
                            cantidad:res.cantidad,
                            subtotal:res.subtotal,
                            idpedido:idpedido,
                            detalle:det
                        }).then(re=>{
                            // console.log(re);
                            if (re.data==1) {
                                this.pedidos=[];
                                this.pedidodialog=false;
                                cm.$toastr.s("Registrado correctamente!!");
                            }else{
                                cm.$toastr.e("Algo salio mal porfavor contactar con el administrador");
                            }
                        });
                    })
                });


                // axios.post('Welcome/pedido',this.usuario)
                //     .then(function (res) {
                //         if (res.data.length>=1){
                //             cm.isusuario=res.data[0];
                //             cm.usuario={};
                //             cm.logindialog=false;
                //             // console.log(cm.isusuario);
                //             cm.$toastr.s("Registrado correctamente!!");
                //             localStorage.setItem('Nombres',cm.isusuario.Nombres);
                //             localStorage.setItem('id',cm.isusuario.Cod_Aut);
                //         }else{
                //             cm.$toastr.e("Algo salio mal");
                //         }
                //     })
            },
            reiniciar(){
                //console.log(this.bebidas);
            },
            selectbebidas(e){
                // console.log(e);
            },
            elipedido(index){
                // console.log(index)
                if (confirm('Seguro de cancelar?')){
                    this.$delete(this.pedidos, index)
                }
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
                this.selectpedido=false;
            },
            getcom(item){
                this.varios=[];
                this.bebidas=[];
                this.agregados=[]
                axios.get('Welcome/getcom/'+item.cod_prod).then(res=>{
                    // console.log(item);
                    this.producto=item;
                    this.cantidad=1;
                    this.selectpedido=true;
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
            selectproduct(id){
              // console.log(id);
                axios.get('Welcome/getproductos/'+id).then(res=>{
                    // console.log(res.data);
                    this.productos=res.data;
                    // console.log(this.productos)
                })
            },
            salir(){
              localStorage.clear();
              this.isusuario={};
            },
            login(){
                let cm=this;
                // console.log(this.usuario);
                axios.post('Welcome/login',this.usuario)
                    .then(async (res)=>{
                        if (res.data.length>=1){
                            // cm.isusuario=res.data[0];
                            // console.log(res.data[0].Nombres);
                            this.isusuario.Nombres= await res.data[0].Nombres;
                            this.isusuario.id=res.data[0].Cod_Aut;
                            this.isusuario.celular=res.data[0].celular;

                            cm.usuario={};
                            // console.log(res.data[0].Nombres);
                            cm.logindialog=false;
                            // console.log(cm.isusuario);
                            cm.$toastr.s("Registrado correctamente!!");
                            localStorage.setItem('Nombres',res.data[0].Nombres);
                            localStorage.setItem('id',res.data[0].Cod_Aut);
                            localStorage.setItem('celular',res.data[0].celular);

                        }else{
                            cm.$toastr.e("Algo salio mal");
                        }
                        // res.forEach(r=>{
                        //     console.log(r);
                        // })
                    })
            },
            guardar(){
                let cm=this;
                // console.log(this.usuario);
                axios.post('Welcome/guardar',this.usuario)
                    .then(function (res) {
                        if (res.data.length==1){
                            // cm.isusuario=res.data[0];
                            cm.usuario={};
                            cm.dialog=false;
                            // console.log(cm.isusuario);
                            cm.$toastr.s("Registrado correctamente!!");
                            localStorage.setItem('Nombres',res.data[0].Nombres);
                            localStorage.setItem('id',res.data[0].Cod_Aut);
                            localStorage.setItem('celular',res.data[0].celular);
                            this.isusuario.Nombres=res.data[0].Nombres;
                            this.isusuario.id=res.data[0].Cod_Aut;
                            this.isusuario.celular=res.data[0].celular;
                        }else{
                            cm.$toastr.e("Algo salio mal");
                        }
                        // res.forEach(r=>{
                        //     console.log(r);
                        // })
                    })
            },
            elegirsucursal(suc){
                this.sucursal=suc;
                this.selectsucursal=false;
                this.tienda= L.latLng(suc.lat, suc.lng);
            }
        },
        computed:{
            dispedido: function(){
                let lat1=this.marker.lat, lon1=this.marker.lng, lat2=this.tienda.lat, lon2=this.tienda.lng
                rad = function(x) {return x*Math.PI/180;}

                var R = 6378.137; //Radio de la tierra en km
                var dLat = rad( lat2 - lat1 );
                var dLong = rad( lon2 - lon1 );

                var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong/2) * Math.sin(dLong/2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                var d = R * c*1000;
                return d.toFixed(2); //Retorna tres decimales
            },
            guar:function () {
                return true;
            },
            total:function (){
                let t=0;
                this.pedidos.forEach(res=>{
                    t+= parseFloat(res.subtotal);
                })
                return t;
            },
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
        },
        data: () => ({
            pedidodialog:false,
            nameRules: [
                v => !!v || 'Campo requerido',
                // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
            ], pedidos: [
                // { imagen: 'https://cdn.vuetifyjs.com/images/lists/1.jpg', producto: 'panes', cantidad: "10",precio: "20",subtotal: "30" },
            ],
            varios:[],
            sucursales:[],
            ex7: '',
            bebi:[],
            bebidas:[],
            agregados:[],
            logindialog:false,
            cantidad:1,
            selectcompocicion:'',
            compocicion:[],
            cantidades: [],
            // pedidos:[],
            selectsucursal:true,
            selectpedido:false,
            producto:{},
            usuario:{},
            grupos:[],
            productos:[],
            sucursal:'',
            dialog: false,
            isusuario: {},
            drawer: null,
            zoom:13,
            center: L.latLng(-17.972914, -67.113125),
            url:'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
            attribution:'&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            marker: L.latLng(-17.972914, -67.113125),
            tienda: L.latLng(-17.972914, -67.113125),
            icon: L.icon({
                iconUrl: 'img/logo.png',
                iconSize: [32, 37],
                iconAnchor: [16, 37]
            }),
        }),
    })
</script>
</body>
</html>
