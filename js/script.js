$(document).ready(function () {
    var menuIcon = $('#menu-icon');
    var navbar = $('.navbar');

    var isPhone = window.matchMedia("(max-width: 768px)");

    // Si es un teléfono
    if (isPhone.matches) {
        menuIcon.on('click', function () {
            menuIcon.toggleClass('fa-bars fa-x');
            navbar.toggle("slow");
        });

        $('#telefonos').click(function () {
            $('#sub-menu').toggle("slow");
        });

        $('.pages').click(function () {
            navbar.toggle("slow");
            menuIcon.toggleClass('fa-bars fa-x');
        });
    }

    // Dinanismo de paginas
    $('.pages').click(function (e) {
        e.preventDefault();

        var pageName = $(this).data('page');
        var telValue = $(this).data('tel');
        var url;
        if (telValue == undefined) {
            url = 'view/' + pageName + '.php';
        } else {
            url = 'view/' + pageName + '.php?tel=' + encodeURIComponent(telValue);
        }

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                $('#main').html(response);
            },
            error: function (error) {
                console.log('Error al cargar el formulario:', error);
            }
        });
    });

    $('.pages2').click(function (e) {
        e.preventDefault();

        var pageName = $(this).data('page');

        $.ajax({
            url: pageName + '.php',
            type: 'GET',
            success: function (response) {
                $('#main').html(response);
            },
            error: function (error) {
                console.log('Error al cargar el formulario:', error);
            }
        });
    });

    // click en el producto
    $(document).on('click', '.card', function (e) {
        e.preventDefault();

        var idValue = $(this).data('id');
        var url = 'view/producto.php?id=' + encodeURIComponent(idValue);

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                $('#main').html(response);
            },
            error: function (error) {
                console.log('Error al cargar el formulario:', error);
            }
        });
    });

    // click en las imagnes
    $(document).on('click', '.imagenes img', function () {
        var src = $(this).attr('src');
        $('#imagenPrincipal').attr('src', src);
    });

    // boton enviar
    $(document).on('click', '#enviar', function (e) {
        e.preventDefault();

        var caracteristicas = $('.caracteristicas').find('p').map(function () {
            return $(this).text();
        }).get().join('\n');z

        Swal.fire({
            title: 'Ingrese un número:',
            input: 'text',
            inputPlaceholder: 'Escribe el número aquí...',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Enviar',
            allowOutsideClick: false,
            inputValidator: (value) => {
                if (!value) {
                    return 'Debes ingresar un número.';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var numero = result.value;
                var numeroCodificado = encodeURIComponent(numero);
                var mensaje = encodeURIComponent("¡Hola! Quieres adquirir este producto. Aquí están las características:\n" + caracteristicas);
                var enlaceWhatsApp = "https://wa.me/57" + numeroCodificado + "/?text=" + mensaje;

                window.open(enlaceWhatsApp, '_blank');
            }
        });
    });

    // boton contacto
    $(document).on('click', '#contacto', function (e) {
        e.preventDefault();

        var referecia = $('#referencia').val();
        var mensaje = encodeURIComponent("¡Hola! Quiero adquirir este producto :" + referecia + " ¿Cómo puedo hacerlo");

        var enlaceWhatsApp = "https://wa.me/573125308417" + "/?text=" + mensaje;
        window.open(enlaceWhatsApp, '_blank');
    });

    // boton wpp
    $(document).on('click', '#wpp', function (e) {
        e.preventDefault();

        var mensaje = encodeURIComponent("¡Hola! Quiero adquirir un producto ¿Cómo puedo hacerlo");

        var enlaceWhatsApp = "https://wa.me/573125308417" + "/?text=" + mensaje;
        window.open(enlaceWhatsApp, '_blank');
    });

    // recuperar clave
    $('#clave').click(function () {
        Swal.fire({
            title: "",
            text: "Comunicate con area de Desarrollo para recuperar la clave.",
            icon: "info"
        });
    })

    // registro
    $('#registro').click(function () {
        Swal.fire({
            title: "",
            text: "Funcionamiento no activo.",
            icon: "error"
        });
    })

    // agregar producto
    $(document).on('submit', '#agregar', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '../php/guardar_producto.php',
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                    });
                    $("#agregar")[0].reset();
                    $("#imagen").val("");
                    $('#sistema, #memoria, #camara, #ram, #bateria, #procesador,#tarjeta, #resolucion, #peso, #pantalla').addClass('hidden');
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                    $("#agregar")[0].reset();
                    $("#imagen").val("");
                    $('#sistema, #memoria, #camara, #ram, #bateria, #procesador,#tarjeta, #resolucion, #peso, #pantalla').addClass('hidden');
                }
            }
        })
    });

    // funcion del formulario
    $(document).on('change', '#categoria', function () {
        var categoria = $(this).val();
        var marca = $('#marca');

        marca.empty().append("<option value=''>--- Marca ---</option>");
        $('#sistema, #memoria, #camara, #ram, #bateria, #procesador,#tarjeta, #wifi, #resolucion, #peso, #pantalla, #dimension').addClass('hidden').empty();

        if (categoria === "Telefono") {
            agregarOpcion(marca, "Xiaomi");
            agregarOpcion(marca, "Iphone");
            agregarOpcion(marca, "Honor");
            agregarOpcion(marca, "Motorrola");
            agregarOpcion(marca, "Oppo");
            agregarOpcion(marca, "Samsung");
            agregarOpcion(marca, "Tecno");
            agregarOpcion(marca, "Vivo");

            $('#sistema, #memoria, #camara, #ram, #bateria, #procesador').removeClass('hidden').val('').empty().prop('required', true);;
            $('#tarjeta, #resolucion, #peso, #pantalla').addClass('hidden').empty().prop('required', false);;

        } else if (categoria === "Televisor") {
            agregarOpcion(marca, "Samsung");
            agregarOpcion(marca, "LG");
            agregarOpcion(marca, "Panasony");
            agregarOpcion(marca, "TCL");
            agregarOpcion(marca, "Kalley");

            $('#resolucion, #pantalla, #peso').removeClass('hidden').val('').empty().prop('required', true);
            $('#tarjeta, #memoria, #camara, #ram, #bateria, #procesador, #sistema').addClass('hidden').empty().prop('required', false);

        } else if (categoria === "Computador") {
            agregarOpcion(marca, "Apple");
            agregarOpcion(marca, "HP");
            agregarOpcion(marca, "Lenovo");
            agregarOpcion(marca, "Samsung");
            agregarOpcion(marca, "Asus");
            agregarOpcion(marca, "Dell");
            agregarOpcion(marca, "Acer");

            $('#sistema, #memoria, #ram, #procesador, #tarjeta').removeClass('hidden').val('').empty().prop('required', true);
            $('#resolucion, #camara, #pantalla, #peso, #bateria').addClass('hidden').empty().prop('required', false);
        }
    });

    function agregarOpcion(select, valor) {
        var opcion = $("<option></option>").attr("value", valor).text(valor);
        select.append(opcion);
    }

    // paginacion
    $(document).on('click', '.btn-pagination', function () {
        var pagina = $(this).data('pagina');
        $.ajax({
            url: '../php/obtener_datos.php',
            type: 'GET',
            data: { pagina: pagina },
            success: function (data) {
                $('.table').html(data);
            },
            error: function () {
                alert('Error al obtener los datos');
            }
        });
    });

    // ocultar producto
    $(document).on('click', '.agotado', function () {
        var idValue = $(this).data('id');
        var formUrl = '../php/agotado.php?id=' + encodeURIComponent(idValue);

        $.ajax({
            url: formUrl,
            type: 'POST',
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                    });
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                }
            }
        });
    });

    // visibilitar producto
    $(document).on('click', '.disponible', function () {
        var idValue = $(this).data('id');
        var formUrl = '../php/disponible.php?id=' + encodeURIComponent(idValue);

        $.ajax({
            url: formUrl,
            type: 'POST',
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                    });
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                }
            }
        });
    });

});