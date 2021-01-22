/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function() {
        //app.receivedEvent('deviceready');
		
		resizingTool();
			
		MapearForms();
		
		ic = 0;
		codigo = 0;
    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
        var parentElement = document.getElementById(id);
        var listeningElement = parentElement.querySelector('.listening');
        var receivedElement = parentElement.querySelector('.received');

        listeningElement.setAttribute('style', 'display:none;');
        receivedElement.setAttribute('style', 'display:block;');

        console.log('Received Event: ' + id);
    }
};


Frm_Cadastro.onsubmit = function()
{
	if (!ConexaoInternet())
	{
		error_in('Sem conexão com a internet!');
	}
	else if (VerificarForm(this))
	{
		AjaxForm(this, "btn_cadastrar.disabled = true;", "var retorno = this.responseText; var indicador = retorno.split(';-;')[0]; var aviso = retorno.split(';-;')[1]; if (indicador == 1) {ic = 1; codigo = retorno.split(';-;')[2]; error_in(aviso);} else {ic = 0; error_in(aviso);} btn_cadastrar.disabled = false;");
	}
	else
	{
		error_in("Por favor, preencha todos os campos corretamente!");
	}
	
	return false;
}

function resizingTool(){
	//Capturando a dimensão da tela
	wScreen = window.innerWidth;
	hScreen = window.innerHeight;
	h10 = hScreen * 0.10;
	h80 = hScreen * 0.80;
	
	//Topbar resizing
	et_topbar.style.height = h10+"px";
	et_back.style.height = h10+"px";
	et_menu.style.height = h10+"px";
	et_space_back.style.height = h10+"px";
	et_space_menu.style.height = h10+"px";
	
	//bottom resizing
	et_bottom.style.height = h10+"px";
}

function error_in(e, aux)
{
	if (aux == 1)
	{
		btn_eout.style.visibility = "hidden";
	}
	else
	{
		btn_eout.style.visibility = "visible";
	}
	
	txt_error.innerHTML = e;//"Por favor, preencha todos os campos corretamente!";
	error.style.visibility = "visible";
	error.style.opacity = "1";
}

function error_out()
{
	error.style.opacity = "0";
	error.style.visibility = "hidden";
	
	if (ic == 1)
	{
		SincronizarDados(codigo);
	}
}

function termos_in()
{
	termos.style.visibility = "visible";
	termos.style.opacity = "1";
}

function termos_out()
{
	termos.style.opacity = "0";
	termos.style.visibility = "hidden";
}