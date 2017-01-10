Vagrant.configure("2") do |config|
  config.vm.box = "guorblam/p-etoile-back"
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 8000, host: 8000

end
