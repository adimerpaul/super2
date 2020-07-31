<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
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
                    <span >{{sucursal}}</span>
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
                    <v-btn small color="primary">Ingresar</v-btn>
                    <v-btn small color="primary" @click="dialog=!dialog">Registrar</v-btn>
                    {{isusuario.Nombres}}
                </div>
            </v-app-bar>
            <v-main>
                <v-container fluid>
                    <v-row  >
                        <v-col cols="12" sm="6" md="6">
                            <h3>Productos</h3>
                            <v-row >
                                <div v-for="item in pedidos" @click="getcom(item)" style="color:white;display:flex;align-items:center;text-align:center;overflow:hidden;font-size:0.6em;width: 90px;height: 70px;background: rgba(3,169,244,0.8);border: 1px solid black">
                                    <div style="text-align: center;width: 100%">
                                        {{item.cod_prod}}<br>
                                        {{item.Producto}}<br>
                                        {{item.Precio| currency}} Bs.<br>
                                        Stock {{item.Saldo}}
                                    </div>
                                </div>
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
                        <span class="headline">User Profile</span>
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
        },
        filters: {
            currency(amount) {
                const amt = Number(amount)
                return amt.toFixed(2);
            }
        },
        methods:{
            getcom(item){
                axios.get('Welcome/getcom/'+item.cod_prod).then(res=>{
                    if (res.data.length==0){
                        this.pedidos.push(item);
                    }else{
                        console.log(res.data);
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
            }
        },
        data: () => ({
            pedidos:[],
            selectsucursal:true,
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
