<?php
namespace App;
class Cohere
{
    /**
     * Faz rerank de conteúdo (exemplo resultados de busca)
     * @param string $query Termo que foi usado na busca
     * @param array $documents Array com os resultados da busca
     * @param int|null $top_n O número de documentos ou índices mais relevantes a serem retornados, o padrão é o comprimento dos documentos
    **/
    public function rerank(string $query, array $documents, int|null $top_n = null):array
    {

        $data = [
            'model' => COHERE_RERANK_MODEL,
            'query' => $query,
            'documents' => $documents
        ];
        if($top_n !== null) {
            $data['top_n'] = $top_n;
        }
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            "Authorization: bearer ".COHERE_API_KEY
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, COHERE_RERANK_ENDPOINT);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $data = ['result' => $documents, 'error' => 'Curl Error: ' . curl_error($ch)];
        } else {
            $data = ['result' => json_decode($response)];
        }
        curl_close($ch);
        return $data;
    }
}