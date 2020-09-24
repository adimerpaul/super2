Vue.use(Toasted)


var app = new Vue({
    el: '#app',
    data: {
        message: 'Hola Vue!',
        caja:1,
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
        pedidos:[
            // {
            //     "imagen": "2",
            //     "producto": "TORTA FRUTILLA  GRANDE",
            //     "idproducto": "954",
            //     "cantidad": 1,
            //     "detalle": [],
            //     "precio": 170,
            //     "subtotal": 170
            // }
        ],
        usuario:{},
    },
    created(){

        // Swal.fire({
        //     title: 'Error!',
        //     text: 'Do you want to continue',
        //     icon: 'error',
        //     confirmButtonText: 'Cool'
        // });
        //
        if (localStorage.getItem("celular") === null) {

        }else{
            this.usuario.celular=localStorage.getItem("celular");
        }
        if (localStorage.getItem("nombre") === null) {

        }else{
            this.usuario.nombre=localStorage.getItem("nombre");
        }
        if (localStorage.getItem("carnet") === null) {

        }else{
            this.usuario.carnet=localStorage.getItem("carnet");
        }
        if (localStorage.getItem("mesa") === null) {

        }else{
            this.usuario.mesa=localStorage.getItem("mesa");
        }

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
        datos(){
            localStorage.setItem("celular",this.usuario.celular);
            localStorage.setItem("nombre",this.usuario.nombre);
            localStorage.setItem("carnet",this.usuario.carnet);
            localStorage.setItem("mesa",this.usuario.mesa);
            this.caja++;
            axios.post('Welcome/ingreso',this.usuario).then(res=>{
               // console.log(res.data);
                this.usuario=res.data[0];
                // console.log(this.usuario);
            });
        },
        selectagre(item){
            // console.log(item);
            this.agregados.forEach(r=>{
                r.cantidad="0";
            })
        },
        agregarpedido(){
            console.log(this.cantidad);
            console.log(parseFloat(this.totalbebidas));
            console.log(parseFloat(this.totalagregados));

            if (this.cantidad==1){

            }else if (parseFloat(this.totalbebidas)!=parseFloat(this.cantidad)){
                if (this.bebidas.length==0){

                }else{
                    alert('no selecionaste bien');
                    return false;
                }
            }else if( parseFloat(this.totalagregados)!=parseFloat(this.cantidad)){
                if (this.agregados.length==0){

                }else{
                    alert('no selecionaste bien');
                    return false;
                }
            }else if (parseFloat(this.totalbebidas)==parseFloat(this.cantidad)||parseFloat(this.totalagregados)==parseFloat(this.cantidad)){

            }else{
                alert('no selecionaste bien');
                return false;
            }

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
            Swal.fire(
                'Agregado!',
                'Agregado',
                'success'
            )
        },
        elegirsucursal(suc){
            this.productos=[];

            this.sucursal=suc;
            // this.selectsucursal=false;
            // this.tienda= L.latLng(suc.lat, suc.lng);
            this.caja++;
        },
        elegirgrupo(item){
            this.caja++;
            this.grupo=item;
            this.productos=[];
            Vue.toasted.show('Cargando...');
            axios.get('Welcome/getproductos/'+item.Cod_grup).then(res=>{
                this.productos=res.data;
                Vue.toasted.clear();
                // console.log(this.productos);
            })
        },
        elipedido(index){
            // console.log(index)
            // if (confirm('Seguro de cancelar?')){

            // }
            Swal.fire({
                title: 'Seguro?',
                text: "Seguro de cancelar este pedido?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'SI'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Eliminado!',
                        'Eliminado correctamente',
                        'success'
                    )
                    this.$delete(this.pedidos, index)
                }
            })
        },
        getcom(item){
            // console.log('aaa')
            this.varios=[];
            this.bebidas=[];
            this.agregados=[];
            Vue.toasted.show('Cargando...');
            axios.get('Welcome/getcom/'+item.cod_prod).then(res=>{
                // console.log(item);
                this.producto=item;
                this.cantidad=1;
                // this.selectpedido=true;
                $('#pedido').modal('show');
                Vue.toasted.clear();
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
        async realizarpedido(){
            if(this.pedidos.length==0){
                Swal.fire(
                    'Deves !',
                    'Tener pedidos',
                    'info'
                )
                return false;
            }
            Swal.fire({
                title: 'Seguro?',
                text: "Seguro de cancelar este pedido?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'SI'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Vue.toasted.show('Enviado pedido...');

                    await  axios.post('Welcome/pedido',{
                        nombre:this.usuario.Nombres,
                        idcliente:this.usuario.Id,
                        celular:this.usuario.celular,
                        mesa:this.usuario.mesa,
                        // lat:this.marker.lat,
                        // lng:this.marker.lng,
                        lat:'',
                        lng:'',
                        total:this.total,
                        idsucursal:this.sucursal.NroAut,
                        costoenvio:0,
                    }).then(async res=>{



                        // let cm=this;

                        let idpedido=await res.data;
                        // console.log(idpedido);
                        await axios.get('Welcome/comanda').then(async res=>{
                            let comanda=res.data;
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

                                // console.log(res.data);
                                await axios.post('Welcome/pedidodetalles',{
                                    idproducto:res.idproducto,
                                    producto:res.producto,
                                    precio:res.precio,
                                    cantidad:res.cantidad,
                                    subtotal:res.subtotal,
                                    idpedido:idpedido,
                                    detalle:det,
                                    ci:this.usuario.Id,
                                    mesa:this.usuario.mesa,
                                    comanda:comanda,
                                }).then(re=>{
                                    // console.log(re);
                                    if (re.data==1) {
                                        this.pedidos=[];
                                        this.pedidodialog=false;
                                        // cm.$toastr.s("Registrado correctamente!!");
                                    }else{
                                        // cm.$toastr.e("Algo salio mal porfavor contactar con el administrador");
                                    }
                                });
                            })

                            Swal.fire(
                                'Enviado!',
                                'Enviado correctamente',
                                'success'
                            );
                            Vue.toasted.clear();
                            this.caja=3;
                            this.pedidos=[];
                        });

                    });

                }
            })

            // this.pedidodialog=true;

            // console.log(this.usuario);
            // let costoenvio=0;
            // if (this.dispedido<1000){
            //     costoenvio=0;
            // }else if (this.dispedido<2000){
            //     costoenvio=10;
            // }else{
            //     costoenvio=20;
            // }
            //console.log(this.total);
            //return false;




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
        total:function (){
            let t=0;
            this.pedidos.forEach(res=>{
                t+= parseFloat(res.subtotal);
            })
            return t;
        },
    }

})
