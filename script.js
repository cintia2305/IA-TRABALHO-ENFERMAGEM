function mostrarMensagem(texto, classe) {
  const chat = document.getElementById("chat");
  const p = document.createElement("p");
  p.className = classe;
  p.textContent = texto;
  chat.appendChild(p);
  chat.scrollTop = chat.scrollHeight;
}

function limparChat(){
  document.getElementById("chat").innerHTML = "";
}
function enviarMensagem() {
  const msg = document.getElementById("campoMensagem").value;

  if (msg.trim() === "") return;

  mostrarMensagem("Você: " + msg, "mensagem-user");
  document.getElementById("campoMensagem").value = "";

  fetch("gemini.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "mensagem=" + encodeURIComponent(msg)
  })
  .then(res => res.json())
  .then(data => {
    mostrarMensagem("Chatbot: " + data.resposta, "mensagem-bot");
  })
  .catch(() => {
    mostrarMensagem("Chatbot: X Erro ao se conectar ao servidor.", "mensagem-bot");
  });
} 
let tamanhoFonte= 16;
function aumentarFonte(){
  tamanhoFonte +=2;
  document.getElementById("chat").style.fontSize = tamanhoFonte + "px";
}
function diminuirFonte(){
  tamanhoFonte -= 2;
  if (tamanhoFonte <10) tamanhoFonte = 10;
  document.getElementById("chat").style.fontSize = tamanhoFonte + "px";
}
