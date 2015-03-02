STATUS FINALIZAÇÃO
======

TAREFA FINALIZADA = 0
NÃO FINALIZADA = 1


#STATUS ANDAMENTO
ANDAMENTO = 2


#STATUS ATIVO  LIGADO/DESLIGADO

LIGADO = 1
DESLIGADO = 0

#ANDAMENTOS
Não inicioado=0
Iniciado=1
Concluido=2
Parado=3
Refazendo=4
Aprovação=5

#ABAS
A FAZER: TODA TAREFA MARCADA COMO "0" em duca_tarefa_clientes(duca_tar_cli_status)
ANDAMENTO: TODA TAREFA QUE ESTA MARCADA COMO (1,3,4,5) em duca_tarefa_clientes(duca_tar_cli_status)
ATRASADO: TODAS AS TAREFAS QUE ESTÃO MARCADAS COMO (1,3,4,5) e a DATA e inferior a Hoje (CURDATE()) em duca_tarefa_clientes(duca_tar_cli_status)
CONCLUDIDO: TODAS AS TAREFAS QUE ESTÃO MARCADAS COMO (2) em duca_tarefa_clientes(duca_tar_cli_status)
FINALIZADOS: TODAS A TAREFAS QUE ESTÃO MARCADAS COMO (0) em duca_tarefas(tar_finalizado)

