/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * función ocultar div alertas
 */
var bPreguntar = false;
    window.onbeforeunload = preguntarAntesDeSalir;
    function preguntarAntesDeSalir()
    {
        if (bPreguntar)
            return "¿Seguro que quieres salir?";
    }
$(document).ready(function() {
    
    setTimeout(function() {
        $(".alert").fadeOut(1500);
    }, 5000);
});
/*
 * Fin función ocultar div alertas
 */

