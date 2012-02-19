<?php

/**
 * agenda actions.
 *
 * @package    ati2Proyecto
 * @subpackage agenda
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class agendaActions extends sfActions {

/**
 *
 * @param sfWebRequest $request
 * @return type
 */
    public function executeCrearEvento(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $this->setLayout(false);
            $this->setTemplate(false);
            $nombre = $request->getParameter("nombre");
            $fecha = $request->getParameter("fecha");

            $evento = new Evento();
            $evento->setNombre($nombre);
            $evento->setFecha($fecha);
            $evento->save();

            $data = array('stateCode' => "200"
            );
            return $this->renderText(json_encode($data));
        }
        return $this->renderText("Esta funcion debe ser llamada via Ajax");
    }

    /**
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeEditarEvento(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $this->setLayout(false);
            $this->setTemplate(false);

            $id = $request->getParameter("id");

            $evento = Doctrine_Core::getTable("Evento")->findOneBy('id', $id);

            if ($evento) {
                $data = array('stateCode' => "200",
                    'nombre' => $evento->getNombre(),
                    'fecha' => $evento->getFecha(),
                    'id' => $evento->getId()
                );
                return $this->renderText(json_encode($data));
            }

            $data = array('stateCode' => "404"
            );
            return $this->renderText(json_encode($data));
        }
        return $this->renderText("Esta funcion debe ser llamada via Ajax");
    }

    /**
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeActualizarEvento(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $this->setLayout(false);
            $this->setTemplate(false);
            $id = $request->getParameter("id");
            $evento = Doctrine_Core::getTable("Evento")->findOneBy('id', $id);
            if ($evento) {
                $nombre = $request->getParameter("nombre");
                $fecha = $request->getParameter("fecha");
                $evento->setNombre($nombre);
                $evento->setFecha($fecha);
                $evento->save();
                $data = array('stateCode' => "200"
                );
                return $this->renderText(json_encode($data));
            }

            $data = array('stateCode' => "404"
            );
            return $this->renderText(json_encode($data));
        }
        return $this->renderText("Esta funcion debe ser llamada via Ajax");
    }

    /**
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeEliminarEvento(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $this->setLayout(false);
            $this->setTemplate(false);
            $id = $request->getParameter("id");
            $evento = Doctrine_Core::getTable("Evento")->findOneBy('id', $id);
            if ($evento) {
                $evento->delete();
                $data = array('stateCode' => "200"
                );
                return $this->renderText(json_encode($data));
            }

            $data = array('stateCode' => "404"
            );
            return $this->renderText(json_encode($data));
        }
        return $this->renderText("Esta funcion debe ser llamada via Ajax");
    }

    public function executeListarEventos(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $this->setLayout(false);
            $this->setTemplate(false);

            $eventos = Doctrine::getTable("evento")
                ->createQuery('a')
                ->fetchArray();


            if (isset($eventos[0])) {

                $data = array('stateCode' => "200",
                    'eventos' => $eventos
                );
                return $this->renderText(json_encode($data));
            }

            $data = array('stateCode' => "201"
            );
            return $this->renderText(json_encode($data));
        }
        return $this->renderText("Esta funcion debe ser llamada via Ajax");
    }

    public function executeEventosDia(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $this->setLayout(false);
            $this->setTemplate(false);
            
            $eventosDia = Doctrine_Core::getTable("Evento")->getEventosDia();
            
            
            if (isset($eventosDia[0])) {
                
                $data = array('stateCode' => "200",
                    'eventosDia' => $eventosDia
                );
                return $this->renderText(json_encode($data));
            }else{
                $data = array('stateCode' => "201",
                    "fecha" => date("y-m-d")
                );
                return $this->renderText(json_encode($data));
            }
            
            $data = array('stateCode' => "404"
            );
            return $this->renderText(json_encode($data));
        }
        return $this->renderText("Esta funcion debe ser llamada via Ajax");
        
    }

    public function executeEventosSemana(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $this->setLayout(false);
            $this->setTemplate(false);

            $eventosSemana = Doctrine_Core::getTable("Evento")->getEventosSemana();


            if (isset($eventosSemana[0])) {

                $data = array('stateCode' => "200",
                    'eventosSemana' => $eventosSemana
                );
                return $this->renderText(json_encode($data));
            }else{
                $data = array('stateCode' => "201",
                    "fecha" => date("y-m-d")
                );
                return $this->renderText(json_encode($data));
            }

            $data = array('stateCode' => "404"
            );
            return $this->renderText(json_encode($data));
        }
        return $this->renderText("Esta funcion debe ser llamada via Ajax");

    }

    public function executeEventosSiete(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $this->setLayout(false);
            $this->setTemplate(false);

            $eventosSiete= Doctrine_Core::getTable("Evento")->getEventosSiete();


            if (isset($eventosSiete[0])) {

                $data = array('stateCode' => "200",
                    'eventosSiete' => $eventosSiete
                );
                return $this->renderText(json_encode($data));
            }else{
                $data = array('stateCode' => "201",
                    "fecha" => date("y-m-d")
                );
                return $this->renderText(json_encode($data));
            }

            $data = array('stateCode' => "404"
            );
            return $this->renderText(json_encode($data));
        }
        return $this->renderText("Esta funcion debe ser llamada via Ajax");

    }

    public function executeEventosMes(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $this->setLayout(false);
            $this->setTemplate(false);

            $eventosMes = Doctrine_Core::getTable("Evento")->getEventosMes();


            if (isset($eventosMes[0])) {

                $data = array('stateCode' => "200",
                    'eventosMes' => $eventosMes
                );
                return $this->renderText(json_encode($data));
            }else{
                $data = array('stateCode' => "201",
                    "fecha" => date("y-m-d")
                );
                return $this->renderText(json_encode($data));
            }

            $data = array('stateCode' => "404"
            );
            return $this->renderText(json_encode($data));
        }
        return $this->renderText("Esta funcion debe ser llamada via Ajax");

    }


}
