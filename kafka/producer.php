<?
$rk = new RdKafka\Producer();
$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers('172.17.0.4');

$cf = new RdKafka\TopicConf();
$cf->set('request.required.acks',-1);
$topic = $rk->newTopic("testKafka",$cf);

for ($i=0;$i<20;$i++){
    $topic->produce(RD_KAFKA_PARTITION_UA,0,"Message $i");
}
$len = $rk->getOutQlen();
if($len > 0){
    var_dump($len);
    $rk->poll(50);
}
