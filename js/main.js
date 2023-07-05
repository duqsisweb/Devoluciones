
// Administrativo panel

const verifys = ['❌' , '✔'];
let usuariosModal = document.getElementById('modalEditUser');
let userSelect = document.getElementById('userSelect');
let alertRetenc = document.getElementById('alertRetenc');
let alertDelete = document.getElementById('alertDelete');
let navMenu = document.querySelector('nav');
let btnMenu = document.querySelector('.btnMenu');
let btnCloseMenu = document.querySelector('.btnCloseMenu');
let text,passwordcorrect,nameDoc;
// document.querySelector('.btnRefresh').style.display = 'none';

const showInput = () => {
    document.querySelector('.formsearchuser').style.display = 'block';
        $.ajax({
            type: "POST",
            url: '../function/usuarios.php',
            data: $(this).serialize(),
            success: function(response){
                let jsonData = JSON.parse(response);

                let dataOptions = '';
                jsonData.map((values) => {
                    dataOptions += `<option value='${values.NOMBRECOMPLETO}'>${values.NOMBRECOMPLETO}</option>`;
                })
                document.getElementById('listamodelos').innerHTML = dataOptions;
           }
       });
}

const buscarUsuario = () => {
    usuariosModal.style.display = 'block';
    let code = userSelect.value.split('--');

    $.ajax({
        type: "POST",
        url: '../function/userspecif.php',
        data: {
            CODIGO: code[0],
        },
        success: function(response){
            let dataUsers;
            let jsonData = JSON.parse(response);

            jsonData.forEach(element => {
                dataUsers = `<section class="containerUser">
                <div>
                    <article class="profile">
                        <img src="../assets/image/logoencabezado.jpg" alt="duquesalogo">
                        <div>
                            <h3 class="nameUser">${element.NOMBRECOMPLETO}</h3>
                            <p class="position">${element.CARGO}</p>
                        </div>
                    </article>
                    
                    <article class="sectionInfo">
                        <p><span>CODIGO:</span> ${element.CODIGO}</p>
                        <p><span>TELEFONO:</span> ${element.TELEFONO}</p>
                    </article>
                    
                    <p class="email"><span>CORREO:</span> ${element.EMAIL}</p>
                    
                    <a href="editarRetenciones.php?codigo=${element.CODIGO}"><button class="btnRetenciones">Editar Certificado Retencion</button></a>
                </div>
                <div>
                    <h2 class="titlePassword">Cambiar la Contraseña del usuario</h2>
                    <button class="closeModalpassAdmin" onclick="closemodalUser()">❌</button>
                    <form action="../function/cambiarContraseña.php" method="POST" class="changePasswordAdmin">
                        <div class="sectioninputsadmin">
                            <label>Contraseña</label>
                            <input id="password" class="passwordAdmin" type="password" name="newpassword" onkeyup="verifyPassword(event)" autocomplete="new-password">
                        </div>

                        <article class="infoFormPassword">
                            <p><span id="longpassword"></span>Minimo 8 caracteres</p>
                            <p><span id="verifyPass"></span>Minimo una letra mayuzcula, un numero y un caracter especial</p>
                        </article> 
                        
                        <div class="sectioninputsadmin">
                            <label>Confirmar Contraseña</label>
                            <input class="passwordAdmin" type="password" name="matchPassword" onchange="matchpass(event)" autocomplete="new-password">
                            <p id="menssagematch" class="containermatch"></p>
                        </div>

                        <input type="hidden" name="emailuser" value="${element.EMAIL}">

                        <div class="btnpasswordAdmin">
                            <input id="btnchangepass" type="submit" name="changepassword" value="Cambiar contraseña" disabled>
                        </div>
                    </form>
                </div>
            </section>`});
            usuariosModal.innerHTML = dataUsers;
       }
   });

}

const closemodalUser = () => {
    usuariosModal.style.display = 'none';
    userSelect.value = '';
}

const deleteReten = (value) => {

    let url = document.getElementById('url').value;

    if (value == 1 && url != '') {
        $.ajax({
            type: "POST",
            url: '../function/eliminar.php',
            data: {
                urldoc: url,
            },
            success: function(response){
                if (response == 1) {
                    let message = 'El documento fue eliminado con exito';
                    showAlertReten(message);
                    document.querySelector('.btnRefresh').style.display = 'block';
                }
           }
       });
       alertDelete.style.display = 'none';

    } else if (url == ''){
        alert("No existe un documento para eliminar");
    } else {
        alertDelete.style.display = 'block';
    }
}

const showAlertReten = (message) => {

    alertRetenc.style.animation = "showAlertReten 0.8s ease-in-out";
    alertRetenc.style.display = "block";
    alertRetenc.innerHTML = `<p>${message}</p>`;

    setTimeout(function() {
        alertRetenc.style.display = "none";
        document.querySelector('.btnRefresh').style.display = 'block';
    },3000);
}

const closeAlertDelete = () => alertDelete.style.display = 'none';

const refreshPage = () => {
    document.querySelector('.btnRefresh').style.display = 'none';
    if (window.history.replaceState) { // verificamos disponibilidad
        window.history.replaceState(null, null, window.location.href);
        location.reload();
    }
}

// Cargar formatos

const showFormNewFormat = () => {
    let formInput = `<form class="container-input" action="" method="post" enctype="multipart/form-data">
            <h2>seleccionar el formato</h2>
            <input type="file" name="documento" id="file-5" class="inputfile inputfile-5"/>
            <label for="file-5">
                <figure>
                    <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                </figure>
            </label>
            <select class="selectOptionFormat" name="tipoFormato" onchange="habilitarCarga()">
                <option selected>Selecciona un tipo de formato</option>
                <option value="1">Pacto Colectivo</option>
                <option value="2">Otros Formatos Gestion Humana</option>
            </select>
            <input class="btnUpDoc" type="submit" value='Subir' disabled>
        </form>
        <button class="btnCloseModalFormDoc" onclick="btnCloseModalFormDoc()">Cancelar</button>`;

    document.getElementById('formFormat').innerHTML = formInput;
}

const habilitarCarga = () => {
    document.querySelector('.btnUpDoc').disabled = false;
}
 
const editFormat = (id) => {

    nameDoc = document.querySelector(`.nombredoc${id}`).textContent;

    let formInput = `<section class="formatoModal">
            <p>¿Que deseas hacer con este documento?</p>
            <div class="btnsConfirmFormat">
                <button onclick="deleteFormat(3)">Borrar</button>
                <a href="./verFormatos.php?nombredoc=${nameDoc}" target="_blank"><button>Ver Formato</button></a>
                <button onclick="btnCloseModalFormDoc()">Cerrar</button>
            </div>
            <section class="confirmaDelete">
                <button onclick="deleteFormat(1,${id})">Si, eliminar</button>
                <button onclick="deleteFormat(2)">No, Cancelar</button>
            </section>
        </section>`;

    document.getElementById('formFormat').innerHTML = formInput;
}

const btnCloseModalFormDoc = () => {
    document.getElementById('formFormat').innerHTML = '';
}

const deleteFormat = (value,id) => {
    
    if (value != 2 && value != 3 && nameDoc != '') {
        $.ajax({
            type: "POST",
            url: '../function/eliminar.php',
            data: {
                urldoc: `../formatos/${nameDoc}`,
                id: id,
            },
        });
        btnCloseModalFormDoc();
        location.reload();
    } else if (value == 3){
        document.querySelector('.confirmaDelete').style.display = 'block';
    } else {
        document.querySelector('.confirmaDelete').style.display = 'none';
    }
}

/* --------------------------- Usuarios panel --------------------------- */

const showMenu = () => {
    navMenu.style.left = '0px';
    btnCloseMenu.style.display = 'block';
    btnMenu.style.display = 'none';
}

const hiddeMenu = () => {
    navMenu.style.left = '-400px';
    btnCloseMenu.style.display = 'none';
    btnMenu.style.display = 'block';
}

// validad cambio de contraseña
function openmodal () {
    document.getElementById('modalopass').style.display = 'block';
}

function verifyPassword (event) {
    text = event.target.value;

    let estatus = /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/.test(text);
    
    if(estatus) {
        passwordcorrect = 1;
    } else {        
        passwordcorrect = 2;
    }

    document.getElementById('longpassword').textContent  = text.length >= 8 ? '✔' : '❌';
    document.getElementById('verifyPass').textContent  = /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/.test(text) ? '✔' : '❌';
}

// verifica que las conraseñas esten correctas y cohinciden 
const matchpass = (event) => {

    if ((text === event.target.value) && (passwordcorrect === 1)) {
        document.getElementById('menssagematch').textContent = 'Las contraseñas coinciden';
        document.getElementById('menssagematch').style.color = 'green';
        document.getElementById('btnchangepass').disabled = false;

    }else{
        document.getElementById('menssagematch').textContent = 'Las contraseñas deben coincidir y cumplir con las condiciones';
        document.getElementById('menssagematch').style.color = 'red';
        document.getElementById('btnchangepass').disabled = true;
    }
}

function closemodalpassword () { document.getElementById('modalopass').style.display = 'none';}

// Devuelde en texto un valor numerico
let numeroALetras = (function() {

    function Unidades(num) {

        switch (num) {
            case 1:
                return 'UN';
            case 2:
                return 'DOS';
            case 3:
                return 'TRES';
            case 4:
                return 'CUATRO';
            case 5:
                return 'CINCO';
            case 6:
                return 'SEIS';
            case 7:
                return 'SIETE';
            case 8:
                return 'OCHO';
            case 9:
                return 'NUEVE';
        }

        return '';
    } //Unidades()

    function Decenas(num) {

        let decena = Math.floor(num / 10);
        let unidad = num - (decena * 10);

        switch (decena) {
            case 1:
                switch (unidad) {
                    case 0:
                        return 'DIEZ';
                    case 1:
                        return 'ONCE';
                    case 2:
                        return 'DOCE';
                    case 3:
                        return 'TRECE';
                    case 4:
                        return 'CATORCE';
                    case 5:
                        return 'QUINCE';
                    default:
                        return 'DIECI' + Unidades(unidad);
                }
            case 2:
                switch (unidad) {
                    case 0:
                        return 'VEINTE';
                    default:
                        return 'VEINTI' + Unidades(unidad);
                }
            case 3:
                return DecenasY('TREINTA', unidad);
            case 4:
                return DecenasY('CUARENTA', unidad);
            case 5:
                return DecenasY('CINCUENTA', unidad);
            case 6:
                return DecenasY('SESENTA', unidad);
            case 7:
                return DecenasY('SETENTA', unidad);
            case 8:
                return DecenasY('OCHENTA', unidad);
            case 9:
                return DecenasY('NOVENTA', unidad);
            case 0:
                return Unidades(unidad);
        }
    } //Unidades()

    function DecenasY(strSin, numUnidades) {
        if (numUnidades > 0)
            return strSin + ' Y ' + Unidades(numUnidades)

        return strSin;
    } //DecenasY()

    function Centenas(num) {
        let centenas = Math.floor(num / 100);
        let decenas = num - (centenas * 100);

        switch (centenas) {
            case 1:
                if (decenas > 0)
                    return 'CIENTO ' + Decenas(decenas);
                return 'CIEN';
            case 2:
                return 'DOSCIENTOS ' + Decenas(decenas);
            case 3:
                return 'TRESCIENTOS ' + Decenas(decenas);
            case 4:
                return 'CUATROCIENTOS ' + Decenas(decenas);
            case 5:
                return 'QUINIENTOS ' + Decenas(decenas);
            case 6:
                return 'SEISCIENTOS ' + Decenas(decenas);
            case 7:
                return 'SETECIENTOS ' + Decenas(decenas);
            case 8:
                return 'OCHOCIENTOS ' + Decenas(decenas);
            case 9:
                return 'NOVECIENTOS ' + Decenas(decenas);
        }

        return Decenas(decenas);
    } //Centenas()

    function Seccion(num, divisor, strSingular, strPlural) {
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let letras = '';

        if (cientos > 0)
            if (cientos > 1)
                letras = Centenas(cientos) + ' ' + strPlural;
            else
                letras = strSingular;

        if (resto > 0)
            letras += '';

        return letras;
    } //Seccion()

    function Miles(num) {
        let divisor = 1000;
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let strMiles = Seccion(num, divisor, 'UN MIL', 'MIL');
        let strCentenas = Centenas(resto);

        if (strMiles == '')
            return strCentenas;

        return strMiles + ' ' + strCentenas;
    } //Miles()

    function Millones(num) {
        let divisor = 1000000;
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let strMillones = Seccion(num, divisor, 'UN MILLON DE', 'MILLONES');
        let strMiles = Miles(resto);

        if (strMillones == '')
            return strMiles;

        return strMillones + ' ' + strMiles;
    } //Millones()

    return function NumeroALetras(num, currency) {
        currency = currency || {};
        let data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
            letrasCentavos: '',
            letrasMonedaPlural: currency.plural || 'PESOS CHILENOS', //'PESOS', 'Dólares', 'Bolívares', 'etcs'
            letrasMonedaSingular: currency.singular || 'PESO CHILENO', //'PESO', 'Dólar', 'Bolivar', 'etc'
            letrasMonedaCentavoPlural: currency.centPlural || 'CHIQUI PESOS CHILENOS',
            letrasMonedaCentavoSingular: currency.centSingular || 'CHIQUI PESO CHILENO'
        };

        if (data.centavos > 0) {
            data.letrasCentavos = 'CON ' + (function() {
                if (data.centavos == 1)
                    return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoSingular;
                else
                    return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoPlural;
            })();
        };

        if (data.enteros == 0)
            return 'CERO ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
        if (data.enteros == 1)
            return Millones(data.enteros) + ' ' + data.letrasMonedaSingular + ' ' + data.letrasCentavos;
        else
            return Millones(data.enteros) + ' ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
    };

    })();
