<?php
require __DIR__ . '/../vendor/autoload.php';

use Hadder\NfseNacional\Dps;

// Mock payload with IBSCBS data
$jsonPayload = '{
    "version": "1.01",
    "infdps": {
        "tpamb": "2",
        "dhemi": "2023-10-27T10:00:00-03:00",
        "veraplic": "1.0.0",
        "serie": "1",
        "ndps": "123",
        "dcompet": "2023-10-27",
        "tpemit": "1",
        "clocemi": "1234567",
        "prest": {
            "cnpj": "12345678000199",
            "regtrib": {
                "opsimpnac": "1",
                "regesptrib": "0"
            }
        },
        "serv": {
            "locprest": {
                "clocprestacao": "1234567"
            },
            "cserv": {
                "ctribnac": "010101",
                "xdescserv": "Servico Teste"
            }
        },
        "valores": {
            "vservprest": {
                "vserv": "100.00"
            },
            "trib": {
                "tribmun": {
                    "tribissqn": "1"
                }
            }
        },
        "ibscbs": {
            "finnfse": "1",
            "cindop": "1001",
            "inddest": "1",
            "valores": {
                "trib": {
                    "gibscbs": {
                        "cst": "01",
                        "cclasstrib": "01"
                    }
                }
            }
        }
    }
}';

$std = json_decode($jsonPayload);
$dps = new Dps($std);
$xml = $dps->render($std);

echo $xml;
if (strpos($xml, '<IBSCBS>') !== false && strpos($xml, '<cIndOp>1001</cIndOp>') !== false && strpos($xml, '<CST>01</CST>') !== false) {
    echo "\n\nSUCCESS: IBSCBS group rendered correctly.\n";
} else {
    echo "\n\nFAILURE: IBSCBS group missing or incorrect.\n";
    exit(1);
}
