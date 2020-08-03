<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                            <v-list-item-title >{{sucursal}}</v-list-item-title>
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
                    {{isusuario.Nombres}}
                </div>
            </v-app-bar>
            <v-main>
                <v-container fluid>
                    <v-row  >
                        <v-col cols="12" sm="6" md="6">
<!--                            <h3>Productos</h3>-->
                            <v-row >
<!--                                <div v-for="item in pedidos" style="color:white;display:flex;align-items:center;text-align:center;overflow:hidden;font-size:0.6em;width: 90px;height: 70px;background: rgba(3,169,244,0.8);border: 1px solid black">-->
<!--                                    <div style="text-align: center;width: 100%">-->
<!--                                        {{item.cod_prod}}<br>-->
<!--                                        {{item.Producto}}<br>-->
<!--                                        {{item.Precio| currency}} Bs.<br>-->
<!--                                        Stock {{item.Saldo}}-->
<!--                                    </div>-->
<!--                                </div>-->
                                <v-card style="width: 100%">
                                    <v-list two-line >
                                        <template >
                                            <v-subheader >Productos</v-subheader>
                                            <v-list-item v-for="(item, index) in pedidos" :key="index" >
                                                <v-list-item-avatar>
                                                    <img :src="item.imagen">
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
                                                    <v-list-item-subtitle  style="text-align: right">Cantidad {{item.cantidad}} Precio {{item.precio}} Subtotal {{item.subtotal}} </v-list-item-subtitle>

                                                </v-list-item-content>
                                            </v-list-item>
                                            <h4 style="text-align: right;padding: 0.5em">TOTAL: {{total}}</h4>

                                        </template>
                                    </v-list>
                                </v-card>
                            </v-row>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                            <h3>Grupos</h3>
                            <v-row >
                                <div v-for="item in grupos" @click="selectproduct(item.Cod_grup)" style="color:white;display:flex;align-items:center;text-align:center;overflow:hidden;font-size:0.8em;width: 90px;height: 70px;background: rgba(103,58,183,0.8);border: 1px solid black">
                                    <div  style="text-align: center;width: 100%">{{item.Descripcion}}</div>
                                </div>
                            </v-row>
                            <h3>Productos</h3>
                            <v-row >
                                <div v-for="item in productos" @click="getcom(item)" style="color:white;display:flex;align-items:center;text-align:center;overflow:hidden;font-size:0.6em;width: 90px;height: 70px;background: rgba(3,169,244,0.8);border: 1px solid black">
                                    <div style="text-align: center;width: 100%">
                                        {{item.cod_prod}}<br>
                                        {{item.Producto}}<br>
                                        {{item.Precio| currency}} Bs.<br>
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
            <v-dialog v-model="selectsucursal" persistent max-width="800">
                <v-card>
                    <v-card-title class="headline">Seleccionar sucursal</v-card-title>
                    <v-card-text>
                        <v-card class="mx-auto" @click="elegirsucursal('SUPER HAMBURGUESAS')">
                            <v-img
                                    class="white--text align-end"
                                    height="120px"
                                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                            >
                                <v-card-title>SUPER HAMBURGUESAS</v-card-title>
                            </v-img>
                        </v-card>
                        <v-card class="mx-auto" @click="elegirsucursal('SUPER 6 DE OCTUBRE')">
                            <v-img
                                    class="white--text align-end"
                                    height="120px"
                                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                            >
                                <v-card-title>SUPER 6 DE OCTUBRE</v-card-title>
                            </v-img>
                        </v-card>
                        <v-card class="mx-auto" @click="elegirsucursal('SUPER PAGADOR')">
                            <v-img
                                    class="white--text align-end"
                                    height="120px"
                                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                            >
                                <v-card-title>SUPER PAGADOR</v-card-title>
                            </v-img>
                        </v-card>
                        <v-card class="mx-auto" @click="elegirsucursal('SUPER 6 SUD')">
                            <v-img
                                    class="white--text align-end"
                                    height="120px"
                                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                            >
                                <v-card-title>SUPER 6 SUD</v-card-title>
                            </v-img>
                        </v-card>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-dialog v-model="selectpedido" persistent max-width="500">
                <v-card >
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline mb-4">Producto</div>
                            <v-list-item-title class="headline mb-1">{{producto.Producto}}</v-list-item-title>
                            <v-list-item-subtitle>
                                <v-row>
                                    <v-col cols="12" sm="4">
                                        <v-select
                                                :items="cantidades"
                                                label="Cantidad"
                                                dense
                                                outlined
                                                width="10"
                                                v-model="cantidad"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" sm="4">
                                        <v-select
                                                :items="[producto.Precio]"
                                                label="Precio"
                                                dense
                                                outlined
                                                width="10"
                                                v-model="producto.Precio"
                                        ></v-select>
                                    </v-col>
                                <v-col cols="12" sm="4">
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
                                <v-row>
                                    <v-col cols="12" sm="6">
                                        <v-select v-if="compocicion.length!=0"
                                                :items="compocicion"
                                                item-text="Producto"
                                                label="Componente"
                                                dense
                                                outlined
                                                width="10"
                                                v-model="selectcompocicion"
                                                :rules="nameRules"
                                        ></v-select>
                                    </v-col>
                                </v-row>
                            </v-list-item-subtitle>
                        </v-list-item-content>

                        <v-list-item-avatar
                                tile
                                size="80"
                                color="grey"
                        ></v-list-item-avatar>
                    </v-list-item>

                    <v-card-actions>
                        <v-btn color="error" @click="selectpedido=!selectpedido"><i class="fa fa-trash"></i>Cancelar</v-btn>
                        <v-btn color="primary" @click="agregarpedido()"><i class="fa fa-plus"></i>Agregar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-app>
    </v-app>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue-toastr/dist/vue-toastr.umd.min.js"></script>
<script>
    new Vue({
        el: '#app',
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
                // console.log(this.isusuario.Nombres)
            }
            axios.get('Welcome/getgrupos').then(res=>{
                this.grupos=res.data;
                // console.log(this.grupos)
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
            elipedido(index){
                // console.log(index)
                if (confirm('Seguro de cancelar?')){
                    this.$delete(this.pedidos, index)
                }

            },
            agregarpedido(){
                // console.log(this.producto);
                this.pedidos.push({ imagen: 'https://cdn.vuetifyjs.com/images/lists/1.jpg', producto: this.producto.Producto, cantidad: this.cantidad,precio: parseFloat(this.producto.Precio) ,subtotal: this.cantidad * this.producto.Precio })
                this.selectpedido=false;
            },
            getcom(item){
                axios.get('Welcome/getcom/'+item.cod_prod).then(res=>{
                    // console.log(item);
                    this.producto=item;
                    this.cantidad=1;
                    this.selectpedido=true;
                    if (res.data.length==0){
                        // this.pedidos.push(item);
                        console.log('no hay composicion');
                        this.compocicion=[];
                        this.compocicion="";
                    }else{
                        // console.log(res.data);
                        this.compocicion=res.data;


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
                    .then(function (res) {
                        if (res.data.length==1){
                            cm.isusuario=res.data[0];
                            cm.usuario={};
                            cm.logindialog=false;
                            // console.log(cm.isusuario);
                            cm.$toastr.s("Registrado correctamente!!");
                            localStorage.setItem('Nombres',cm.isusuario.Nombres);
                            localStorage.setItem('id',cm.isusuario.Cod_Aut);
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
                            cm.isusuario=res.data[0];
                            cm.usuario={};
                            cm.dialog=false;
                            // console.log(cm.isusuario);
                            cm.$toastr.s("Registrado correctamente!!");
                            localStorage.setItem('Nombres',cm.isusuario.Nombres);
                            localStorage.setItem('id',cm.isusuario.Cod_Aut);
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
            }
        },
        computed:{
            guar:function () {
                return true;
            },
            total:function (){
                let t=0;
                this.pedidos.forEach(res=>{
                    t+= parseFloat(res.subtotal);
                })
                return t;
            }
        },
        data: () => ({
            nameRules: [
                v => !!v || 'Campo requerido',
                // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
            ], pedidos: [
                // { imagen: 'https://cdn.vuetifyjs.com/images/lists/1.jpg', producto: 'panes', cantidad: "10",precio: "20",subtotal: "30" },
            ],
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
            items: [
                { icon: 'mdi-contacts', text: 'Contacts' },
                { icon: 'mdi-history', text: 'Frequently contacted' },
                { icon: 'mdi-content-copy', text: 'Duplicates' },
                {
                    icon: 'mdi-chevron-up',
                    'icon-alt': 'mdi-chevron-down',
                    text: 'Labels',
                    model: true,
                    children: [
                        { icon: 'mdi-plus', text: 'Create label' },
                    ],
                },
                {
                    icon: 'mdi-chevron-up',
                    'icon-alt': 'mdi-chevron-down',
                    text: 'More',
                    model: false,
                    children: [
                        { text: 'Import' },
                        { text: 'Export' },
                        { text: 'Print' },
                        { text: 'Undo changes' },
                        { text: 'Other contacts' },
                    ],
                },
                { icon: 'mdi-cog', text: 'Settings' },
                { icon: 'mdi-message', text: 'Send feedback' },
                { icon: 'mdi-help-circle', text: 'Help' },
                { icon: 'mdi-cellphone-link', text: 'App downloads' },
                { icon: 'mdi-keyboard', text: 'Go to the old version' },
            ],
        }),
    })
</script>
</body>
</html>
