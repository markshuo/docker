<?php
$conf = new RdKafka\Conf();
//$conf->setDrMsgCb(function ($kafka, $message) {
//    file_put_contents("./c_dr_cb.log", var_export($message, true), FILE_APPEND);
//});
//$conf->setErrorCb(function ($kafka, $err, $reason) {
//    file_put_contents("./err_cb.log", sprintf("Kafka error: %s (reason: %s)", rd_kafka_err2str($err), $reason).PHP_EOL, FILE_APPEND);
//});

//设置消费组
$conf->set('group.id', 'myConsumerGroup');

$rk = new RdKafka\Consumer($conf);
$rk->addBrokers("172.17.0.4");

$topicConf = new RdKafka\TopicConf();
$topicConf->set('request.required.acks', 1);
//在interval.ms的时间内自动提交确认、建议不要启动
//$topicConf->set('auto.commit.enable', 1);
$topicConf->set('auto.commit.enable', 0);
$topicConf->set('auto.commit.interval.ms', 100);

// 设置offset的存储为file
//$topicConf->set('offset.store.method', 'file');
// 设置offset的存储为broker
$topicConf->set('offset.store.method', 'broker');
//$topicConf->set('offset.store.path', __DIR__);

//smallest：简单理解为从头开始消费，其实等价于上面的 earliest
//largest：简单理解为从最新的开始消费，其实等价于上面的 latest
//$topicConf->set('auto.offset.reset', 'smallest');

$topic = $rk->newTopic("testKafka", $topicConf);

// 参数1消费分区0
// RD_KAFKA_OFFSET_BEGINNING 重头开始消费
// RD_KAFKA_OFFSET_STORED 最后一条消费的offset记录开始消费
// RD_KAFKA_OFFSET_END 最后一条消费
$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);
//$topic->consumeStart(0, RD_KAFKA_OFFSET_END); //
//$topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);

while (true) {
    //参数1表示消费分区，这里是分区0
    //参数2表示同步阻塞多久
    $message = $topic->consume(0, 12 * 1000);
    if (is_null($message)) {
        sleep(1);
        echo "No more messages\n";
        continue;
    }
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
            var_dump($message);
            break;
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
            echo "No more messages; will wait for more\n";
            break;
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
            echo "Timed out\n";
            break;
        default:
            throw new \Exception($message->errstr(), $message->err);
            break;
    }
}