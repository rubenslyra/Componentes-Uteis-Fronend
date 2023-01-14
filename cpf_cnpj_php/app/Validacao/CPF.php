<?php 

namespace App\Validacao;

class CPF
{
    // Estático porque não precisa de instância
    /**
     * Método que valida um CPF
     *
     * @param string $cpf | Sempre será uma string de 11 caracteres para podermos iniciar o valor com 0
     * @return bool
     */ 
    public static function validar($cpf)
    {
        // Ao invés de usar o preg_match, podemos usar o filter_var, que é mais simples e mais rápido.
            
        $cpf = preg_replace('/[^0-9]/', '', $cpf); // 1. Remove tudo que não for número e retorna uma string com 11 caracteres.

        // Validação do tamanho da string
        if(strlen($cpf) != 11) {
            return false;
        }
        
        // Dígitos verificadores
        $cpfValidacao = substr($cpf, 0, 9); // inicia na posição 0 e pega 9 caracteres
        // Primeiro dígito verificador
        $cpfValidacao .= self::calcularDigitoVerificador($cpfValidacao);
        // Segundo dígito verificador
        $cpfValidacao .= self::calcularDigitoVerificador($cpfValidacao);
        
        # $cpf = preg_replace('/\D/', '', $cpf);  // 2. Remove tudo que não for número e retorna uma string com 11 caracteres.

        // return filter_var($cpf, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/']]);
        
        /*
            Ao iniciarmos a depuração, veremos que o valor de $cpf é 364.420.810-79 com 14 caracteres, incluindo os pontos, traço e números.
            Para que o preg_match funcione, precisamos que o valor de $cpf seja 36442081079 com 11 caracteres, sem pontos, traço e números.        
        
        */
      
        // Validação do CPF
        return $cpfValidacao === $cpf; // 3. Compara o valor de $cpf (enviado) com o valor de $cpfValidacao (calculado). Se forem iguais, retorna true, senão retorna false.
    }

    /**
     * Método que calcula o dígito verificador
     *
     * @param string $cpf
     * @return string
     */
    private static function calcularDigitoVerificador($base)
    {
        $tamanho = strlen($base);
        $multiplicador = $tamanho + 1;
        $soma = 0;

        for($i = 0; $i < $tamanho; $i++) {
           $soma += $base[$i] * $multiplicador;
           $multiplicador--;
        }
       
        // Resto da divisão por 11
        $resto = $soma % 11;
        
        // Busca o valor do dígito verificador
        return $resto > 1 ? 11 - $resto : 0; // Se o resto for maior que 1, retorna 11 - resto, senão retorna 0.
        
        # return $resto < 2 ? 0 : 11 - $resto;
        }
}