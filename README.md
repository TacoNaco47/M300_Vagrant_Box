M300 - Vagrant Box
======

Dieses Repository behandelt die Installation eines Multi-VM-Umgebung mit Vagrant und Virtual Box.

#### Einleitung

Die nachstehende Dokumentation wurde von Michael Blickenstorfer im Rahmen des Moduls M300 (Plattformübergreifende Dienste in ein Netzwerk integrieren)
erarbeitet und zeigt alle Schritte auf, die es zur Einrichtung einer vollständig funktionsfähigen Toolumgebung benötigt.

> Wichtig: <br>
> Für die Durchführung der nachfolgenden Aufgaben, muss zuerst die Dokumentation M300_Toolumgebung konsultiert worden sein. Diese liefert uns die Grundlage für die Erstellung von virtuellen Maschinen.


#### Revision History

| Datum         | Änderungen                                                                         |  Kürzel  |
| ------------- |:-----------------------------------------------------------------------------------| :------: |
| 25.09.2018    | Dokumentation erstellt & hochgeladen                                               |    MBL   |
| 30.10.2018    | Grafiken eingefügt, kleine Verbesserungen gemacht                                  |    MBL   |
|      ...      | ...                                                                                |    ...   |

#### Voraussetzungen
* [X] macOS High Sierra (Version 10.13.6)
* [X] VirtualBox (Version 5.2.18)
* [X] Vagrant (Version 2.1.4)
* [X] Text-Editor (z.B. Visual Studio Code)

#### Inhaltsverzeichnis
* 01 - [Vorbereitungen](https://github.com/TacoNaco47/M300_Vagrant_Box#-01---vorbereitungen)
* 02 - [Box hinzufügen](https://github.com/TacoNaco47/M300_Vagrant_Box#-02---box-hinzuf%C3%BCgen)
* 03 - [VMs konfigurieren](https://github.com/TacoNaco47/M300_Vagrant_Box#-03---vms-konfigurieren)
* 04 - [Provisionierung](https://github.com/TacoNaco47/M300_Vagrant_Box#-04---provisionierung)
* 05 - [Ordner-Synchronisation](https://github.com/TacoNaco47/M300_Vagrant_Box#-05---ordner-synchronisation)
* 06 - [Port-Weiterleitunng](https://github.com/TacoNaco47/M300_Vagrant_Box#-06---port-weiterleitunng)
* 07 - [Quellenverzeichnis](https://github.com/TacoNaco47/M300_Vagrant_Box#-07---quellenverzeichnis)

___

![](https://github.com/TacoNaco47/M300_Vagrant_Box/blob/master/images/Preparations_36x36.png?raw=true "Vorbereitungen") 01 - Vorbereitungen
======

> [⇧ **Nach oben**](https://github.com/TacoNaco47/M300_Vagrant_Box#m300---vagrant-box)

Für die Erstellung einer Multi-Maschinen-Umgebung mit Vagrant muss zuallererst das sogenannte Vagrantfile erstellt werden. Dies ist eine Datei, welche alle notwendigen Konfigurationselemente beherrbergt, die zur Erstellung der einzelnen VMs benötigt werden.

Die Datei erfüllt folgende Zwecke:
1. Das Vagrantfile legt fest, wo sich das Projekt befindet. Dieses "Root-Directory" ist für viele Konfigurationseinstellungen unabdingbar.
2. Mit dem Vagrantfile werden Anzahl Maschinen und Ressourcen (inkl. Software) definiert, die für den Betrieb benötigt werden.

### Vagrantfile erstellen
1. Terminal starten
2. Projektordner erstellen, wo das Projekt liegen soll:
    ```Shell
      $ mkdir MeinVagrantProjekt
      $ cd MeinVagrantProjekt
    ```
3. Vagrantfile erstellen:
    ```Shell
      $  vagrant init
    ```

Mit dem letzten Befehl wird das Vagrantfile im aktuellen Verzeichnis `MeinVagrantProjekt` erstellt. 


![](https://github.com/TacoNaco47/M300_Vagrant_Box/blob/master/images/Add_Box_36x36.png?raw=true "Box hinzufügen") 02 - Box hinzufügen
======

> [⇧ **Nach oben**](https://github.com/TacoNaco47/M300_Vagrant_Box#m300---vagrant-box)

Als nächstes benötigen wir eine Vagrant Box, die uns eine Art "System-Image" (Abbild) liefert, auf welchem wir unsere eigene Konfiguration mit den Services aufbauen können.

Unter https://app.vagrantup.com/boxes/search findet man alle öffentlich verfügbaren Boxen, die frei verwendbar sind. In unserem Fall nutzen wir die `bento/ubuntu-16.04` Box, die [hier](https://app.vagrantup.com/bento/boxes/ubuntu-16.04) näher beschrieben ist.

Vagrant Boxen lassen sich nicht einfach so per Maus-Klick herunterladen. Sie werden direkt im Terminal dem lokalen "Repository" hinzugefügt. Dazu müssen folgende Schritte durchgeführt werden:

1. Terminal starten
2. Vagrant Box hinzufügen:
    ```Shell
      $  vagrant box add bento/ubuntu-16.04
    ```

Der letzte Befehl lädt die Box herunter und fügt sie Vagrant hinzu. Sobald wir nun im Vagrantfile diese Box mitgeben, wird die Anwendung eine VM mit diesem "Image" verwendet. 

> Wichtig: <br> 
> Falls die Box noch nicht mit den Befehl `vagrant box add` hinzugefügt wurde, ist dies nicht weiter schlimm. Vagrant sucht automatisch im [Katalog](https://app.vagrantup.com/boxes/search) nach der entsprechenden Box.


![](https://github.com/TacoNaco47/M300_Vagrant_Box/blob/master/images/VM_Config_36x36.png?raw=true "VMs konfigurieren") 03 - VMs konfigurieren
======

> [⇧ **Nach oben**](https://github.com/TacoNaco47/M300_Vagrant_Box#m300---vagrant-box)

Die VM könnte nun fast ohne weitere Probleme gestartet werden. Jedoch müssen wir im Vagrantfile noch angeben, welche hinzugefügte Box verwendet werden soll. Dazu müssen folgende Schritte umgesetzt werden:

1. Terminal öffnen
2. In das Projekt-Verzeichnis wechseln
3. Das Vagrantfile mit einem **GUI-Editor** öffnen (z.B. Visual Studio Code)
4. Folgenden Inhalt einfügen:
    ```Ruby
      Vagrant.configure("2") do |config|

        config.vm.provision :shell, inline: "echo A"

            config.vm.define :apache do |web|
            web.vm.box = "bento/ubuntu-16.04"
            web.vm.provision :shell, path: "bootstrap.sh"
            web.vm.network :forwarded_port, guest: 80, host: 4567
            end
            
            config.vm.define :database do |db|
            db.vm.box = "bento/ubuntu-16.04"
            end
        end
    ```

Dies ist eine ganz schöne Menge an Code. Aber keine Sorge, der Code ist leicht zu verstehen! 

`Vagrant.configure("2") do |config|` <br>
Ist der Header des Vagrantfiles. Er legt die grundsätzliche Konfiguration fest und ist über die Variable **config** ansprechbar.

`config.vm.provision :shell, inline: "echo A"` <br>
Dient uns lediglich zum Verständnis. Bei der anschliessenden Erstellung der VM wird im Output der Konsole nämlich "A" ausgegeben.

`config.vm.define :apache do |web|` <br>
Definiert die erste Virtuelle Maschine (VM), die **apache** heisst und über die Variable **web** anzusprechen ist.

`web.vm.(...)` <br>
Hier wird die VM konfiguriert. So wird beispielsweise mit **web.vm.box = ""bento/ubuntu-16.04"** definiert, welche Vagrant Box verwendet werden soll.

`config.vm.define :database do |db|` <br>
Dieser Code-Abschnitt definiert die zweite VM und ist im Prinzip gleich wie die Defintion der 1. VM.


Jetzt aber weiter mit dem Start! Denn auf alle anderen Punkte wird in den nachfolgenden Abschnitten genauer eingegangen.


![](https://github.com/TacoNaco47/M300_Vagrant_Box/blob/master/images/Software-Konfiguration_36x36.png?raw=true "Provisionierung") 04 - Provisionierung
======

> [⇧ **Nach oben**](https://github.com/TacoNaco47/M300_Vagrant_Box#m300---vagrant-box)

Soweit ist alles start-bereit und die beiden VMs könnten gestartet werden. In der Config ist uns aber folgender Punkt bei der Konfiguration der Web-VM (apache) aufgefallen:
```Ruby
    web.vm.provision :shell, path: "bootstrap.sh"
```

Diese Konfiguration zeigt auf ein Skript (**bootstrap.sh**), dass in der Shell ausgeführt werden soll. Genau hier kommt die Provisionierung ins Spiel. Den das bootstrap.sh Script macht nichts anderes, als den Apache-Webserver zu installieren und eine kleine Ordnerumleitung einzurichten. Wie das geht, erfährst du nachfolgend. 

1. Terminal öffnen
2. In das Projekt-Verzeichnis wechseln
3. Mit Text-Editor die Datei `bootstrap.sh` erstellen und folgenden Inhalt einfügen:
```Shell
    #!/usr/bin/env bash

    apt-get update
    apt-get install -y apache2

    if ! [ -L /var/www ]; then
    rm -rf /var/www
    ln -fs /vagrant /var/www
    fi
```
4. Das Script bzw. die Datei speichern & schliessen

Nun haben wir alle Vorbereitungen getroffen und das Environment bzw. die VMs können gestartet werden:

1. Bei geöffnetem Terminal die VM Provisionierung starten:
```Shell
    $ vagrant up
```
2. Nach erfolgreichem Start mit SSH auf eine der beiden VMs verbinden:
```Shell
    $ vagrant ssh [apache|databse]
```
3. In der VM können nun bei bedarf weitere Konfigurationen vorgenommen werden. Nun aber mit `CTRL + D` die Verbindung wieder schliessen.
   
<br>
Ob der Webserver mit Apache auch wirklich läuft, werden wir jetzt prüfen. Dazu müssen folgende Schritte gemacht werden:
1.  Im Projekt-Verzeichnis einen Ordner mit dem Namen "html" erstellen
2.  In diesem Ordner eine HTML-Datei ablegen (oder direkt von https://html5up.net/ eine kleine Vorlage holen)
3.  Folgende Adresse aufrufen: http://127.0.0.1:4567 und das Ergebnis betrachten

Nun ist soweit alles eingerichtet. Aber aufgepasst: In den zwei letzten Abschnitten werden die beiden letzten Geheimnisse um die Konfiguration gelüftet!

![](https://github.com/TacoNaco47/M300_Vagrant_Box/blob/master/images/Reflexion_36x36.png?raw=true "Ordner-Synchronisation") 05 - Ordner-Synchronisation
======

> [⇧ **Nach oben**](https://github.com/TacoNaco47/M300_Vagrant_Box#m300---vagrant-box)

Interessant zu sehen war, dass wir die HTML-Dateien für die Webseite lokal in unserem Projektordner abgelegt haben. Doch wie konnte VM auf diese Daten zugreifen? Lösung: **Ordner-Synchronisation**

Vagrant richtet voll-automatisch einen Shared-Folder ein, welcher über den Projektordner aufgerufen werden kann. 

Im `bootstrap.sh` Script haben wir zudem auf VM-Ebene eine Umleitung zu `/vagrant` gemacht. `/vagrant` entspricht dabei dem Projektordner selbst. Das heisst, dass alle Dateien, die lokal in diesem Ordner abgelegt werden, in der VM unter `/vagrant` erscheinen. Also auch das Script und die HTML-Dateien. 

Auf `/vagrant` kann man direkt zugreifen, sobald man sich per SSH verbindet. Ausgangsverzeichnis ist dabei `/home/vagrant` und mit `cd /vagrant` wechselt man anschliessend in das Shared-Folder Verzeichnis.


![](https://github.com/TacoNaco47/M300_Vagrant_Box/blob/master/images/Forward_36x36.png?raw=true "Port-Weiterleitunng") 06 - Port-Weiterleitunng
======

> [⇧ **Nach oben**](https://github.com/TacoNaco47/M300_Vagrant_Box#m300---vagrant-box)

Das letzte Geheminis ist die Portweiterleitung. 

Als wir die Webseite mit http://127.0.0.1:4567 aufgerufen haben, kam ein anderer Port zum Einsatz, als der Standard-Port 80 für HTTP-Webseiten. 
Der Grund dafür liegt im Vagrantfile. Dort haben wir beim Apache-Webserver die Zeile `web.vm.network :forwarded_port, guest: 80, host: 4567` eingetragen. Die Zeile richtet eine sogenannte Port-Weiterleitung ein. Das heisst, alle Anfragen auf Port 4567 an die VM werden auf den Port 80 umgeleitet. Dies ist vor allem dann nützlich, wenn Sicherheitsaspekte bei der Entwicklung von Web-Applikationen berücksichtigt werden müssen.

Alles klar soweit? Ich hoffe schon!


![](https://github.com/TacoNaco47/M300_Vagrant_Box/blob/master/images/Discover_36x36.png?raw=true "Quellenverzeichnis") 07 - Quellenverzeichnis
======

> [⇧ **Nach oben**](https://github.com/TacoNaco47/M300_Vagrant_Box#m300---vagrant-box)

In diesem Abschnitt möchte ich zur Hilfe verwendete Quellen transparent offen legen.
<br>
<br>
Für das Setup der VMs habe ich mich nach der offiziellen Dokumentation von den Vagrant-Entwicklern orientiert:<br>
https://www.vagrantup.com/intro/getting-started/index.html

Bei der Erstellung einer Multi-Maschinen-Umgebung, nahm ich zudem folgende Dokumentation zur Hilfe:<br>
https://www.vagrantup.com/docs/multi-machine/ 

Als ich mit der HTML-Anzeige Probleme hatte, half mir folgender Forum-Post weiter:<br>
https://stackoverflow.com/questions/30960478/trouble-with-vagrant-404-not-found

Weitere Unterstützung durch:<br>
* https://stackoverflow.com/questions/5127838/where-does-php-store-the-error-log-php5-apache-fastcgi-cpanel
* https://stackoverflow.com/questions/2852748/pdoexception-could-not-find-driver
  