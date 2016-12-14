var 
	app     = require('http').createServer(handler),
	io      = require('socket.io')(app),
	fs      = require('fs'),
	port    = process.argv[3] || 9898,
	serialport = require('serialport'),
	SerialPort = serialport.SerialPort,
	portName   = process.argv[2],
	portConfig = {
		baudRate: 115200,
		parity  : "none",
		dataBits: 8,
		parser  : serialport.parsers.readline('\n')
	};

	sp = new SerialPort(portName, portConfig);


	function handler(req, res)
	{
		fs.readFile(__dirname+'/index.html', function(err, data)
		{
			if(err)
			{
				res.writeHead(500);
				return res.end("Error ");
			}
			res.writeHead(200);
			res.end(data);
		});
	}

	arduinoMessage = '';

	sendMessage = function(buffer, socket, context){
		arduinoMessage += buffer.toString();
		console.log(arduinoMessage);

		if(arduinoMessage.indexOf('#') >= 0){
			socket.emit('notif', {context: context, data:arduinoMessage});
			console.log(context);
			console.log("Send Data To Laravel :");
			console.log(arduinoMessage);
			arduinoMessage = "";
		}
	};

	//connect
	io.sockets.on('connection', function(socket){
		
		//--------------Scan Form Tambah Data -----------------
		socket.on('simpan', function(data){
			console.log(data);
			sp.write(data.menu, function(err){//kirim data ke arduino dari web
				console.log('pilih menu ---------> '+data.menu);
			});
			
			sp.on('data', function(data){//terima data 
				arduinoMessage += data.toString();
				//console.log(arduinoMessage);
				if(arduinoMessage.indexOf('#') >= 0){
					socket.volatile.emit('simpan', data);
					console.log("Data To Laravel ----------> "+arduinoMessage);
					arduinoMessage = "";
				}
			});
		});

		socket.on('tarik', function(data){
			console.log(data);
			sp.write(data.menu, function(err){//kirim data ke arduino dari web
				console.log('pilih menu ---------> '+data.menu);
			});

			sp.on('data', function(data){//terima data
				arduinoMessage += data.toString();
				//console.log(arduinoMessage);
				if(arduinoMessage.indexOf('#') >= 0){
					socket.volatile.emit('tarik', data);
					console.log("Data To Laravel ----------> "+arduinoMessage);
					arduinoMessage = "";
				}
			});
		});
		//--------------- END Scan Form Tambah Data -----------------

		//--------------- Tambah Data -----------------
		socket.on('tambah-data', function(dataFromWeb){
			console.log("Data Form Web -----------------------> ");
			console.log(dataFromWeb);
			sp.write(dataFromWeb.menu, function(err){//kirim data ke arduino dari web
				console.log('pilih menu ---------> '+dataFromWeb.menu);
			});
			sp.on('data', function(data){//terima data 
				arduinoMessage += data.toString();
				if(arduinoMessage.indexOf('tambah#') >= 0){
					console.log('Data From Arduino 1 :'+arduinoMessage);
					sp.write(dataFromWeb.data, function(err){

					});
					msg = "";
					sp.on('data', function(data_msg){
						msg += data_msg.toString();
						console.log(msg);

						if(msg.indexOf('#') >= 0){
							socket.volatile.emit('tambah-data', {data:msg});
							console.log('Data From Arduino 2 :'+msg);
							msg = "";
						}
					});
					arduinoMessage = "";
				}
			});
		});


		// socket.on('tambah-data', function(dataFromWeb){
		// 	console.log("Send Data To Arduino :");	

		// 	sp.write('b\n', function(err){ //----------------> pilih menu b di arduino
		// 		console.log('Send Data : b\n');
		// 		if (err) {
		// 			console.log('Error on write: ', err);
		// 		}
		// 		var context = "a";

		// 		sp.on('data', function(data){//terima data 
		// 			arduinoMessage += data.toString();
		// 			console.log(arduinoMessage);
		// 			if(arduinoMessage.indexOf('tambah#') >= 0){

		// 				sp.write(new Buffer(dataFromWeb, 'ascii'), function(err){ //----------------> kirim data berbentuk json
		// 					console.log('Send Data :');
		// 					console.log(dataFromWeb);
		// 					console.log('---------------------------------------------------');
		// 					if (err) {
		// 						return console.log('Error on write: ', err.message);
		// 					}
		// 					var context = "tambah-data";
		// 					sp.on('data', function(dataFromArduion){//terima data 
		// 						sendMessage(dataFromArduion, socket, context);
		// 					});	
		// 				});
		// 			}

		// 		});

		// 	});

		// });

		// socket.on('edit', function(send){
		// 	sp.write(send, function(err){//kirim data ke arduino dari web
		// 		var context = "edit"; //--------------------------------->
		// 		if (err) {
		// 			return console.log('Error on write: ', err.message);
		// 		}
		// 		console.log('Send Data : '+send);
		// 		sp.on('data', function(data){//terima data 
		// 			sendMessage(data, socket, context);

		// 		});
		// 	});
		// });
		
	});


	
	sp.on('close', function(err) {
		console.log('Port closed!');
	});

	sp.on('error', function(err) {
		console.error('error', err);
	});

	sp.on('open', function() {
		console.log('Port opened!');
	});


	app.listen(port);//localhost:9898
	console.log('Running http://localhost:'+port+'/');
