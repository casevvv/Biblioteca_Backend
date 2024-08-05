$(document).ready(function () {
    // Solicitar los datos iniciales
    axios.get('/obtener-datos')
        .then(response => {
            actualizarGraficos(response.data);
        });


    // Función para crear gráficos
    function crearGrafico(id, tipo, datos, options) {
        switch (tipo) {
            case 'bar':
                new Chartist.Bar('#' + id, datos, options);
                break;
            case 'line':
                new Chartist.Line('#' + id, datos, options);
                break;
            case 'pie':
                new Chartist.Pie('#' + id, datos, options);
                break;
            default:
                console.error('Tipo de gráfico no soportado:', tipo);
        }
    }

    // Opciones de configuración por defecto
    const defaultOptions = {
        fullWidth: true,
        height: '20%',
        width: '100%',
        responsive: true,
        maintainAspectRatio: false
    };

    // Función para actualizar los gráficos
    function actualizarGraficos(data) {
        crearGrafico('grafico1', 'bar', data.librosPorCategoria, defaultOptions);
        crearGrafico('grafico2', 'line', data.prestamosPorMes, defaultOptions);
        crearGrafico('grafico3', 'pie', data.librosDisponibles, defaultOptions);
    }


    // Actualizar gráficos al cambiar el filtro
     // Función para actualizar los gráficos
     function actualizarGraficos(data, filtro) {
        let titulo1, titulo2, titulo3, tipo1, tipo2, tipo3;

        switch (filtro) {
            case 'libros-por-categoria':
                titulo1 = 'Libros por Categoría';
                tipo1 = 'bar';
                crearGrafico('grafico1', tipo1, data.librosPorCategoria, defaultOptions);
                break;
            case 'libros-disponibles':
                titulo2 = 'Libros Disponibles';
                tipo2 = 'pie';
                crearGrafico('grafico3', tipo3, data.librosDisponibles, defaultOptions);
                break;
            case 'libros-prestados':
                titulo3 = 'Libros Prestados';
                tipo3 = 'pie';
                crearGrafico('grafico3', tipo3, data.librosPrestados, defaultOptions);
                break;
            case 'libros-mas-populares':
                titulo1 = 'Libros Más Populares';
                tipo1 = 'bar';
                crearGrafico('grafico1', tipo1, data.librosMasPopulares, defaultOptions);
                break;
            case 'autores-mas-populares':
                titulo2 = 'Autores Más Populares';
                tipo2 = 'bar';
                crearGrafico('grafico1', tipo1, data.autoresMasPopulares, defaultOptions);
                break;
            case 'usuarios-mas-activos':
                titulo3 = 'Usuarios Más Activos';
                tipo3 = 'bar';
                crearGrafico('grafico1', tipo1, data.usuariosMasActivos, defaultOptions);
                break;
            case 'prestamos-por-mes':
                titulo1 = 'Préstamos por Mes';
                tipo1 = 'line';
                crearGrafico('grafico2', tipo2, data.prestamosPorMes, defaultOptions);
                break;
            case 'reservas-por-mes':
                titulo2 = 'Reservas por Mes';
                tipo2 = 'line';
                crearGrafico('grafico2', tipo2, data.reservasPorMes, defaultOptions);
                break;
            default:
                console.error('Filtro no soportado:', filtro);
        }

        $('#titulo-grafico1').text(titulo1);
        $('#titulo-grafico2').text(titulo2);
        $('#titulo-grafico3').text(titulo3);
    }

    // Actualizar gráficos al cambiar el filtro
    $('#filtro').change(function () {
        const filtro = $(this).val();
        axios.get('/obtener-datos', { params: { filtro: filtro } })
            .then(response => {
                actualizarGraficos(response.data, filtro);
            })
            .catch(error => {
                console.error('Error al actualizar los gráficos:', error);
            });
    });
});
