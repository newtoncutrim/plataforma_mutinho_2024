@extends('front.layouts.app')

@section('body')
  <div id="app">
    <header>
      <div class="menu">
        <ul>
            <li><a href="{{asset('/timeline?id=')}}">Sobre o Cliente</a></li>
            <li><a href="">Estrategia Geral</a></li>
            <li><a href="">Identidade Visual</a></li>
            <li><a href="">Planejamentos</a></li>
            <li><a href="">Resultados</a></li>
        </ul>
    </div>
    </header>
    <section class="content">
      @yield('content')
    </section>
    <footer>
     {{--  Footer --}}
    </footer>
  </div>
@endsection
<style scoped>
  /* Estilos Globais */
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    color: #333;
    background-color: #f4f4f4;
  }
  
  /* Header */
  header {
    background-color: #333;
    color: #fff;
    padding: 1rem 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .menu {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
  }
  
  .menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: space-around;
  }
  
  .menu ul li {
    margin: 0;
  }
  
  .menu ul li a {
    color: #fff;
    text-decoration: none;
    padding: 0.5rem 1rem;
    transition: background-color 0.3s;
  }
  
  .menu ul li a:hover {
    background-color: #575757;
    border-radius: 4px;
  }
  
  /* Content Section */
  .content {
    padding: 2rem 1rem;
    max-width: 1200px;
    margin: 0 auto;
    background-color: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
  }
  
  /* Footer */
  footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 1rem 0;
    position: relative;
    bottom: 0;
    width: 100%;
    box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
  }
  
  footer p {
    margin: 0;
    font-size: 0.875rem;
  }
  </style>