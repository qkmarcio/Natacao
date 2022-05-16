<?php

Class cExpedicion {

    public function __construct() {
        
    }

    public function getListaSepIS($o) {
        $query = "select ROUND(F.itens / (select Round(sum(g.itens)/sum(g.OUT_TIME_SEPARACION)) Itens_Hora from VI_WEB_SEPARACION_CONFERENCIA g where g.idsepardor=f.idsepardor and g.fimsep between $o->inicio and $o->fim))MEDIA, F.pedidos,F.separador,F.itens,F.in_time_separacion,F.vendedor,F.cliente,F.trasnportadora,F.id_equipe EQUIPES,F.nome_equipe FROM VI_WEB_SEPARACION_CONFERENCIA f where F.status= 'IS' order by f.in_time_separacion";

        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->equipes = $obj->EQUIPES;
            $cls->pedidos = $obj->PEDIDOS;
            $cls->media = $obj->MEDIA.' Min';
            $cls->nome = $obj->SEPARADOR;
            $cls->itens = $obj->ITENS;
            $cls->tempo = $obj->IN_TIME_SEPARACION.' Min';
            $cls->vendedor = $obj->VENDEDOR;
            $cls->cliente = $obj->CLIENTE;
            $cls->trasnportadora = $obj->TRANSPORTADORA;
            $array[] = $cls;
        }
        return $array;
    }
    
    public function getListaSepRank($o) {
        $query = "select count(F.pedidos) pedidos,F.separador,sum(cast(f.itens as integer)) itens,Round((sum(F.itens)/iif(sum(OUT_TIME_SEPARACION) = 0,1,sum(OUT_TIME_SEPARACION)))*60) Itens_Hora,sum(OUT_TIME_SEPARACION)/60 Horas,((sum(cast(f.itens as integer))*0.1) + Round((sum(F.itens)/iif(sum(OUT_TIME_SEPARACION) = 0,1,sum(OUT_TIME_SEPARACION)))*60)) punto,f.id_equipe EQUIPES FROM VI_WEB_SEPARACION_CONFERENCIA f where f.fimsep between $o->inicio and $o->fim and F.IDSEPARDOR not in (1,2,25) group by separador,idsepardor,EQUIPES order by punto DESC";
        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->equipes = $obj->EQUIPES;
            $cls->pedidos = $obj->PEDIDOS;
            $cls->nome = $obj->SEPARADOR;
            $cls->itens = $obj->ITENS;
            $cls->tempo = $obj->HORAS;
            $cls->itens_hora = $obj->ITENS_HORA;
            $cls->punto = round($obj->PUNTO);
            $array[] = $cls;
        }
        return $array;
    }
    
    public function getListaConfRank($o) {
        $query = "select count(F.pedidos) pedidos,F.conferente,sum(cast(f.itens as integer)) itens,Round((sum(F.itens)/iif(sum(out_time_conferencia) = 0,1,sum(out_time_conferencia)))*60) Itens_Hora,sum(out_time_conferencia) Horas,((sum(cast(f.itens as integer))*0.1) + Round((sum(F.itens)/iif(sum(out_time_conferencia) = 0,1,sum(out_time_conferencia)))*60)) punto,(select e.equi_id from tab_equipes e inner join tab_lequipes ep on e.equi_id = ep.lequi_equi_id where ep.lequi_fun_id =f.IDCONFERENTE) EQUIPES FROM VI_WEB_SEPARACION_CONFERENCIA f where f.fimconferencia between $o->inicio and $o->fim and F.IDCONFERENTE not in (1, 25) group by f.conferente,IDCONFERENTE order by punto DESC";

        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->equipes = $obj->EQUIPES;
            $cls->pedidos = $obj->PEDIDOS;
            $cls->nome = $obj->CONFERENTE;
            $cls->itens = $obj->ITENS;
            $cls->tempo = $obj->HORAS;
            $cls->itens_hora = $obj->ITENS_HORA;
            $cls->punto = round($obj->PUNTO);
            $array[] = $cls;
        }
        return $array;
    }
    
    public function getListaEquipeRank($o) {
        $query = "select count(F.pedidos) pedidos,F.nome_equipe,sum(cast(f.itens as integer)) itens,Round((sum(F.itens)/iif(sum(TIME_EQUIPE) = 0,1,sum(TIME_EQUIPE)))*60) Itens_Hora,sum(TIME_EQUIPE) Horas,((sum(cast(f.itens as integer))*0.1) + Round((sum(F.itens)/iif(sum(TIME_EQUIPE) = 0,1,sum(TIME_EQUIPE)))*60)) punto,f.id_equipe EQUIPES FROM VI_WEB_SEPARACION_CONFERENCIA f where f.fimconferencia between $o->inicio and $o->fim and F.IDCONFERENTE not in (1, 25) and f.id_equipe is not null group by EQUIPES,nome_equipe order by punto DESC";

        $c = new cConexao();
        $con = $c->conFirebird();
        $result = ibase_query($con, $query) or die(ibase_errmsg() . "<br>sql utilizado: " . $query);
        while ($obj = ibase_fetch_object($result)) {
            $cls = new stdClass();
            $cls->equipes = $obj->EQUIPES;
            $cls->pedidos = $obj->PEDIDOS;
            $cls->nome = $obj->NOME_EQUIPE;
            $cls->itens = $obj->ITENS;
            $cls->tempo = $obj->HORAS;
            $cls->itens_hora = $obj->ITENS_HORA;
            $cls->punto = round($obj->PUNTO);
            $array[] = $cls;
        }
        return $array;
    }    
}
