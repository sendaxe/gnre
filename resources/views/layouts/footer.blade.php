
<div class="container">
    @if(isset($empresa))
    <span class="text-muted">{{str_pad($empresa->codigo,2,'0',STR_PAD_LEFT)}} - {{$empresa->nome}} - {{$empresa->cnpj}}</span>
    @else
    <span class="text-muted">
        SENDA - Sistema de Engenharia de Dados
    </span>
    @endif
</div>