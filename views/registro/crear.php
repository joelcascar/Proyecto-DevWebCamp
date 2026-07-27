<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo ?? ''; ?></h2>
    <p class="registro__descripcion">Elige tu plan</p>
    <div class="paquetes__grid">
        <div class="paquete">
            <h3 class="paquete__nombre">Pase Gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso virtual a DevWebCamp</li>
            </ul>
            <p class="paquete__precio">$0</p>
            <form method="POST" action="/finalizar-registro/gratis">
                <input class="paquetes__submit" type="submit" value="Inscripción gratis">
            </form>
        </div> <!-- paquete -->

        <div class="paquete">
            <h3 class="paquete__nombre">Pase Presencial</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Presencial a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 dias</li>
                <li class="paquete__elemento">Acceso a talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a las Grabaciones</li>
                <li class="paquete__elemento">Camisa del evento</li>
                <li class="paquete__elemento">Comida y Bebida</li>
            </ul>
            <p class="paquete__precio">$199</p>

            <form method="POST" action="/finalizar-registro/pagar">
                <input type="submit" class="paquetes__submit" value="Inscripción Presencial">
            </form>

            <!-- <div id="paypal-container-JCFAE9FFDLQUJ"></div>
            <script>
                paypal.HostedButtons({
                    hostedButtonId: "JCFAE9FFDLQUJ",
                }).render("#paypal-container-JCFAE9FFDLQUJ")
            </script> -->

            <!-- <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div> -->


        </div> <!-- paquete -->

        <div class="paquete">
            <h3 class="paquete__nombre">Pase Virtual</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 dias</li>
                <li class="paquete__elemento">Enlace a talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a las Grabaciones</li>
            </ul>
            <p class="paquete__precio">$49</p>

            <!-- <div id="paypal-container-SDFBBHQW2TJ8G"></div> -->
            <!-- <script>
                paypal.HostedButtons({
                    hostedButtonId: "SDFBBHQW2TJ8G",
                }).render("#paypal-container-SDFBBHQW2TJ8G")
            </script> -->
        </div> <!-- paquete -->

    </div> <!-- Grid  -->
</main>

<!-- <script
    src="https://www.paypal.com/sdk/js?client-id=BAAJ7mcl-6GzunXyjLy-2xmkljxAtAAHQdi9VJmWp0mPCFWDUY5fx2rbQpnJwzQnSa2z8G8-N2HxZDFnfE&enable-funding=venmo&currency=MXN" data-sdk-integration-source="button-factory">
</script> -->

<!-- <script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'pay',
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "1",
                        "amount": {
                            "currency_code": "MXN",
                            "value": 199
                        }
                    }]
                });
            },

            onAprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    const datos = new FormData();
                    datos.append('paquete_id', orderData.purchase_units[0].description);
                    datos.append('pago_id', orderData.purchase_units[0].payments.capture[0].id);

                    fetch('/finalizar-registro/pagar', {
                            method: 'POST',
                            body: datos
                        })
                        .then(respuesta => respuesta.json())
                        .then(resultado => {
                            if (resultado.resultado) {
                                actions.redirect('http://localhost:3000/finalizar-registro/conferencias');
                            }
                        })
                });
            },

            onError: function(err) {
                console.log(err);
            }

        }).render('#paypal-button-container');
    }

    initPayPalButton();
</script> -->