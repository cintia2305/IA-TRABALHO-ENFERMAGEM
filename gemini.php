<?php
header("Content-Type: application/json");

// Pega a mensagem enviada pelo usuário via POST
$mensagem = $_POST["mensagem"] ?? "";

// SUA chave da API do Google AI Studio (necessária para usar o Gemini)
$api_key = "AIzaSyBfCis1FnTLPNR9nWwcOdIKbzgYqXl297g";

// URL da API do Gemini
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $api_key;

// PROMPT enviado para a IA
$prompt_iot = "
Você é um assistente virtual que explica conceitos básicos de enfermagem com Iot.
Responda SEMPRE de forma bem resumida (no máximo 3 frases).
Use apenas texto simples, sem negrito, sem asteriscos e sem formatação.
Fale simples, como se fosse para iniciantes.
Mensagem: $mensagem 
";

// Dados que serão enviados para a API do Gemini
$data = [
  "contents" => [
    [
      "parts" => [
        ["text" => $prompt_iot]
      ]
    ]
  ]
];

// Configuração da requisição CURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// Tratamento de erros
if (curl_errno($ch)) {
  echo json_encode(["resposta" => "> Erro ao conectar à IA: " . curl_error($ch)]);
  exit;
}
curl_close($ch);

// Converte resposta JSON da API em array PHP
$json = json_decode($response, true);

// Pega a resposta do texto gerado pela IA
$resposta = $json["candidates"][0]["content"]["parts"][0]["text"]
  ?? "X A IA não respondeu. Verifique sua API KEY.";

// Retorna a resposta final para o JavaScript
echo json_encode(["resposta" => $resposta]);
?>
