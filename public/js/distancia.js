"use strict";
(function(){
  const selectDistancias = document.getElementById("distancia");
  const KmsInput = document.getElementById("kmsInput");
  selectDistancias.addEventListener('change',enviarForm);
  function enviarForm(e){
    KmsInput.value = selectDistancias.value;
    document.enviarDistancias.submit();
  }
})();
