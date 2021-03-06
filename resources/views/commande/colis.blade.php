
@extends('racine')

@section('title')
   Gestion des Colis
@endsection


@section('style')

<link rel="stylesheet" href="{{ url('/vendor/css/vendor.bundle.addons.css') }}">
<link rel="stylesheet" href="{{ url('/vendor/css/vendor.bundle.addons.css') }}">

    <style>

        .dropdown.dropdown-lg .dropdown-menu {
            margin-top: -1px;
            padding: 6px 20px;
        }
        .input-group-btn .btn-group {
            display: flex !important;
        }
        .btn-group .btn {
            border-radius: 0;
            margin-left: -1px;
        }
        .btn-group .btn:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .btn-group .form-horizontal .btn[type="submit"] {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        }
        .form-horizontal .form-group {
            margin-left: 0;
            margin-right: 0;
        }
        .form-group .form-control:last-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .sidebar-nav ul .sidebar-item {
            width: auto !important;
        }

        @media screen and (min-width: 768px) {
            #adv-search {
                width: 500px;
                margin: 0 auto;
            }
            .dropdown.dropdown-lg {
                position: static !important;
            }
            .dropdown.dropdown-lg .dropdown-menu {
                min-width: 500px;
            }
        }
        .page-link {
            color: #e85f03 !important;
        }
        .page-item.active .page-link {

            background-color: #e85f03 !important;
            border-color: #e85f03 !important;
            color: #fff !important;
        }
    </style>
@endsection


@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-5">
            <h4 class="page-title">Gestion des Colis</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Quickoo</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="/commandes">Colis</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-7">
        <div class="row float-right d-flex ">
            <div class="m-r-5" style="margin-right: 10px;">
                <a  class="btn btn-warning text-white"  data-toggle="modal" data-target="#modalSearchForm"><i class="fa fa-search"></i></a>
            </div>
            @can('client-admin')
            <div class="m-r-5">
                <a  class="btn btn-danger text-white"  data-toggle="modal" data-target="#modalSubscriptionForm"><i class="fa fa-plus-square"></i> Ajouter</a>
            </div>
            @endcan
        </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        @if (session()->has('search'))
        <div class="alert alert-dismissible alert-warning col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Aucun r??sultat trouv?? !</strong> Il n'existe aucun numero de commande et aucun statut avec : {{session()->get('search')}}  </a>.
          </div>
        @endif
        @if (session()->has('statut'))
        <div class="alert alert-dismissible alert-success col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succ??s !</strong> La commande a ??t?? bien enregistr??e <a  href="commandes/{{session()->get('statut')}}" class="alert-link">(Voir la commande)</a>.
          </div>
        @endif

        @if (session()->has('produit_required'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Attention !</strong> Il faut mentionner les produits de la commande
          </div>
        @endif

        @if (session()->has('delete'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succ??s !</strong> La commande numero {{session()->get('delete')}} ?? ??t?? bien supprim??e !
          </div>
        @endif

        @if (session()->has('stock_insuf'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Attention !</strong> Le stock de l'article {{session()->get('stock_insuf')}} est insuffisant !
          </div>
        @endif

        @if (session()->has('edit'))
        <div class="alert alert-dismissible alert-info col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Succ??s !</strong> Le statut de la commande numero {{session()->get('edit')}} ?? ??t?? bien edit?? !
          </div>
        @endif
        @if (session()->has('noedit'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Attention !</strong>vous ne pouvez pas changer le statut La commande numero {{session()->get('noedit')}}
          </div>
        @endif

        @if (session()->has('nonExpidie'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Attention !</strong>Commande d??j?? trait??e  {{session()->get('nonExpidie')}} <br>
                vous pouvez modifier que les statuts des commandes qui ont le statut <b>Expidi??</b>
        </div>
        @endif
        @if (session()->has('blgenere'))
        <div class="alert alert-dismissible alert-danger col-12">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Attention !</strong>vous ne pouvez pas changer le statut de La commande numero {{session()->get('blgenere')}} <br>
                => le bon de livraison pour cette commande ?? ??t?? d??j?? g??n??r??
        </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Gestion des comandes / colis</h4>
                    <h6 class="card-subtitle">Nombre total des commandes : <code>{{$total}} Commandes</code> .</h6>
                </div>
                <div class="table-responsive">
                    <form method="GET" action="{{route('facture.storeBySelect')}}">
                        @csrf
                        <input type="hidden" name="livreur" value="2">
                        <button style="margin: 20px;" type="submit" class="btn btn-primary">G??n??rer une facture</button>

                    <table  style="font-size: 0.72em;" id="order-listing"  class="table table-hover">
                        <thead>
                            <tr>
                                @can('ramassage-commande')
                                    <th  class="bs-checkbox " style="width: 36px; " data-field="state"><div class="th-inner "><label>
                                        <input  id="check_bl" onclick="checkFunction()" name="btSelectAll" type="checkbox">
                                        </label></div>
                                    </th>
                                    <th scope="col">Client</th>
                                @endcan
                                <th scope="col">Numero Commande</th>
                                <th scope="col">Nom Complet</th>
                                <th scope="col">T??l??phone</th>
                                <th scope="col">Ville</th>
                                <th scope="col">Adresse</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Prix de Livraison</th>
                                <th scope="col">Date</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Ticket</th>

                            </tr>
                        </thead>
                        <tbody id="myTable">

                           @forelse ($commandes as $index => $commande)
                           <tr>
                            @can('ramassage-commande')

                                    <td class="bs-checkbox " style="width: 36px; "><label>

                                            <input value="{{$commande->id}}" class="cb" name="btSelectItem[]" type="checkbox">
                                            <span></span>
                                            </label>


                                    </td>
                            <th scope="row">
                                <a title="{{$users[$index]->name}}" class=" text-muted waves-effect waves-dark pro-pic"

                                            @can('edit-users')
                                                href="{{route('admin.users.edit',$users[$index]->id)}}"
                                            @endcan

                                    >
                                    <img src="{{$users[$index]->image}}" alt="user" class="rounded-circle" width="31">
                                </a>
                            </th>
                            @endcan
                            <th scope="row">

                                @if ($commande->facturer != 0)

                                    <a href="{{route('facture.infos',$commande->facturer)}}" style="color: white; background-color: #e85f03"
                                    class="badge badge-pill" >
                                    <span style="font-size: 1.25em">Factur??e</span>
                                    </a>
                                    <br>
                                @else
                                    @if ($commande->traiter != 0)
                                    <a href="{{route('bon.infos',$commande->traiter)}}" style="color: white"
                                    class="badge badge-pill badge-dark">
                                    <span style="font-size: 1.25em">Bon livraison</span>
                                    </a>
                                    <br>
                                    @endif
                                @endif
                                {{$commande->numero}}

                            </th>
                            <td>{{$commande->nom}}</td>
                            <td>{{$commande->telephone}}</td>
                            <td>{{$commande->ville}}</td>
                            <td>{{$commande->adresse}}</td>
                            @if ($commande->montant > 0)
                            <td>{{$commande->montant}} MAD</td>
                            @else
                            <td> <i class="far fa-credit-card"></i> CARD PAYMENT
                            </td>
                            @endif

                            <td>{{$commande->prix}} MAD</td>
                            <td>{{$commande->created_at}}</td>
                            <td>

                                <a  style="color: white"
                                    class="badge badge-pill
                                    @switch($commande->statut)
                                    @case("expidi??")
                                    badge-warning"
                                    @can('ramassage-commande')
                                    title="Rammaser la commande"
                                     href="{{ route('commandeStatut',['id'=> $commande->id]) }}"
                                    @endcan
                                        @break
                                    @case("En cours")
                                    @case("Report??")
                                    badge-info"
                                        @if ($commande->traiter > 0)
                                        title="Voir le bon de livraison"
                                        href="{{route('bon.gen',$commande->traiter)}}"
                                        target="_blank"
                                        @else
                                        title="G??n??rer le bon de livraison"
                                        href="{{route('bonlivraison.index')}}"
                                        @endif

                                        @break
                                    @case("Livr??")
                                    badge-success"
                                    @if ($commande->facturer > 0)
                                        title="Voir la facture"
                                        href="{{route('facture.gen',$commande->facturer)}}"
                                        target="_blank"
                                        @else
                                        title="G??n??rer la facture"
                                        href="{{route('facture.index')}}"
                                        @endif
                                        @break
                                    @default
                                    badge-danger"
                                @endswitch
                                "
                                     >
                                     <span style="font-size: 1.25em">{{$commande->statut}}</span>
                                </a>
                                <br>
                                @if ($commande->statut == "Report??" )
                                Pour le: <br>{{$commande->postponed_at}}
                                @else
                                ({{\Carbon\Carbon::parse($commande->updated_at)->diffForHumans()}})

                                @endif
                            </td>
                           <td style="font-size: 1.5em"><a title="Voir le detail" style="color: #e85f03" href="/commandes/{{$commande->id}}"><i class="mdi mdi-eye"></i></a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align: center">Aucune commande enregistr??e!</td>
                        </tr>

                           @endforelse

                        </tbody>

                    </table>
                </form>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container my-4">
    <div class="modal fade" id="modalSearchForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Rechercher sur les commandes</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="GET" action="{{route('commande.filter')}}">
                                @csrf
                                @can('ramassage-commande')
                                <div class="form-group row">
                                    <label for="client" class="col-sm-4">Fournisseur :</label>
                                    <div class="col-sm-8">
                                        <select name="client" id="client" class="form-control form-control-line" value="{{ old('client') }}">
                                            <option value="" disabled selected>Choisissez le fournisseur</option>
                                            @foreach ($clients as $client)
                                        <option value="{{$client->id}}" class="rounded-circle">
                                            {{$client->name}}
                                        </option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                @endcan

                                <div class="form-group row">
                                    <label class="col-md-4">Nom et Pr??nom:</label>
                                    <div class="col-md-8">
                                        <input  value="{{ old('nom') }}" name="nom" type="text" placeholder="Nom & Pr??nom" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Statut de commande:</label>
                                    <div class="col-sm-8">
                                        <select name="statut" class="form-control form-control-line">
                                            <option selected disabled>Choisissez le statut</option>
                                            <option>Expidi??</option>
                                            <option>en cours</option>
                                            <option>Livr??</option>
                                            <option>Retour Complet</option>
                                            <option>Retour Partiel</option>
                                            <option>Report??</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-date-input" class="col-4 col-form-label">Date Min</label>
                                    <div class="col-8">
                                      <input class="form-control" name="dateMin" type="date" value="{{now()}}" id="example-date-input">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="example-date-input" class="col-4 col-form-label">Date Max</label>
                                    <div class="col-8">
                                      <input class="form-control" name="dateMax"  type="date" value="{{now()}}" id="example-date-input">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-4">Ville :</label>
                                    <div class="col-sm-8">
                                        <select name="ville" class="form-control form-control-line">
                                            <option selected disabled>Choisissez la ville</option>
                                            <option value="Tanger">Tanger</option>
                                            <option value="Marrakech">Marrakech</option>
                                            <option value="K??nitra">K??nitra</option>
                                            <option value="Casablanca">Casablanca</option>
                                            <option value="Rabat">Rabat</option>
                                        </select>
                                    </div>
                                </div>
                                  <div class="form-group row">
                                    <label for="example-date-input" class="col-3 col-form-label">Montant Min</label>
                                    <div class="col-3">
                                      <input class="form-control" name="prixMin" type="number" value="0" id="example-date-input">
                                    </div>
                                    <label for="example-date-input" class="col-3 col-form-label">Montant Max</label>
                                    <div class="col-3">
                                      <input class="form-control" type="number" name="prixMax" value="0" id="example-date-input">
                                    </div>
                                  </div>

                                  <div class="from-group row">
                                    <label for="bl" class="col-sm-3">BL g??n??r??</label>
                                    <div class="col-3">
                                      <input class="form-control" name="bl" type="checkbox" value="1" id="bl">
                                    </div>
                                    <label for="facture" class="col-sm-3">Factur??e</label>
                                    <div class="col-3">
                                      <input class="form-control" name="facturer" type="checkbox" value="1" id="facture">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Rechercher</button>

                                    </div>
                                </div>
                            </form>
                        </div>

                      </div>
                    </div>
    </div>
</div>




<div class="container my-4">
    @can('manage-users')
    <div class="modal fade" id="modalSubscriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header text-center">
                          <h4 class="modal-title w-100 font-weight-bold">Nouvelle Commande</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body mx-3">
                            <form class="form-horizontal form-material" method="POST" action="{{route('commandes.store')}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="client" class="col-sm-12">Fournisseur :</label>
                                    <div class="col-sm-12">
                                        <select name="client" id="client" class="form-control form-control-line" value="{{ old('client') }}" required>
                                            <option value="" disabled selected>Choisissez le fournisseur</option>
                                            @foreach ($clients as $client)
                                        <option value="{{$client->id}}" class="rounded-circle">
                                            {{$client->name}}
                                        </option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-12">Numero de la commande :</label>
                                  <div class="col-md-12">
                                      <input  value="{{ old('numero') }}" name="num" type="text" placeholder="Numero de la commande (Optionnel)" class="form-control form-control-line">
                                  </div>
                              </div>
                                <div class="form-group">
                                    <label class="col-md-12">Nom et Pr??nom du destinataire :</label>
                                    <div class="col-md-12">
                                        <input  value="{{ old('nom') }}" name="nom" type="text" placeholder="Nom & Pr??nom" class="form-control form-control-line">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="example-email" class="col-md-12">Nombre de Colis :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('colis') }}" type="number" class="form-control form-control-line" name="colis" id="example-email">
                                        </div>
                                    </div>


                                    <fieldset class="form-group col-md-4">
                                        <div class="row">
                                          <legend class="col-form-label  pt-0">Poids :</legend>
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input   class="form-check-input" type="radio" name="poids" id="normal" value="normal" checked>
                                              <label class="form-check-label" for="normal">
                                                P. Normal
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input   class="form-check-input" type="radio" name="poids" id="voluminaux" value="voluminaux">
                                              <label class="form-check-label" for="voluminaux">
                                                P. Volumineux
                                              </label>
                                            </div>

                                          </div>
                                        </div>
                                      </fieldset>
                                      <fieldset class="form-group col-md-4">
                                        <div class="row">
                                          <legend class="col-form-label  pt-0">Mode de paiement :</legend>
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cd" value="cd" checked>
                                              <label class="form-check-label" for="cd">
                                                Cash on delivery
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input  onclick="myFunction2(this.value)" class="form-check-input" type="radio" name="mode" id="cp" value="cp">
                                              <label class="form-check-label" for="cp">
                                                Card payment
                                              </label>
                                            </div>

                                          </div>
                                        </div>
                                      </fieldset>

                                      <div class="form-group col-md-12" id="montant" style="display: block">
                                        <label for="example-email" class="col-md-12">Montant (MAD) :</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('montant') }}" type="number" class="form-control form-control-line" name="montant" id="example-email">
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-12">T??l??phone :</label>
                                    <div class="col-md-12">
                                        <input value="{{ old('telephone') }}"  name="telephone" type="text" placeholder="0xxx xxxxxx" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Adresse :</label>
                                    <div class="col-md-12">
                                        <textarea  name="adresse" rows="5" class="form-control form-control-line">{{ old('adresse') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Ville :</label>
                                    <div class="col-sm-12">
                                        <select name="ville" class="form-control form-control-line" id="ville" onchange="myFunction()" required>
                                            <option checked>Choisissez la ville</option>
                                            <option value="Tanger">Tanger</option>
                                            <option >Marrakech</option>
                                            <option >K??nitra</option>
                                            <option >Casablanca</option>
                                            <option >Rabat</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display: none"  class="form-group" id="secteur">
                                    <label class="col-sm-12">Secteur :</label>
                                    <div class="col-sm-12">
                                      <select  value="{{ old('secteur') }}" name="secteur" class="form-control form-control-line" required>

                                          <option value="">Tous les secteurs</option>
                                              <option>Aviation</option>
                                              <option>Al Kasaba</option>
                                              <option>Cap spartel</option>
                                              <option>Centre ville</option>
                                              <option>Cit?? californie</option>
                                              <option>Girari</option>
                                              <option>Ibn Taymia</option>
                                              <option>M'nar</option>
                                              <option>M'sallah</option>
                                              <option>Makhoukha</option>
                                              <option>Malabata</option>
                                              <option>Marchane</option>
                                              <option>Marjane</option>
                                              <option>Moujahidine</option>
                                              <option>Moulay Youssef</option>
                                              <option>Santa</option>
                                              <option>Val Fleuri</option>
                                              <option>Vieille montagne</option>
                                              <option>Ziatene</option>
                                              <option>Autre secteur</option>
                                              <option>Achennad</option>
                                              <option>Aharrarine</option>
                                              <option>Ahlane</option>
                                              <option>Aida</option>
                                              <option>Al Anbar</option>
                                              <option>Al Warda</option>
                                              <option>Aouama Gharbia</option>
                                              <option>Beausejour</option>
                                              <option>Behair</option>
                                              <option>Ben Dibane</option>
                                              <option>Beni Makada Lakdima</option>
                                              <option>Beni Said</option>
                                              <option>Beni Touzine</option>
                                              <option>Bir Aharchoune</option>
                                              <option>Bir Chifa</option>
                                              <option>Bir El Ghazi</option>
                                              <option>Bouchta-Abdelatif</option>
                                              <option>Bouhout 1</option>
                                              <option>Bouhout 2</option>
                                              <option>Dher Ahjjam</option>
                                              <option>Dher Lahmam</option>
                                              <option>El Baraka</option>
                                              <option>El Haj El Mokhtar</option>
                                              <option>El Khair 1</option>
                                              <option>El Khair 2</option>
                                              <option>El Mers 1</option>
                                              <option>El Mers 2</option>
                                              <option>El Mrabet</option>
                                              <option>Ennasr</option>
                                              <option>Gourziana</option>
                                              <option>Haddad</option>
                                              <option>Hanaa 1</option>
                                              <option>Hanaa 2</option>
                                              <option>Hanaa 3 - Soussi</option>
                                              <option>Jirrari</option>
                                              <option>Les Rosiers</option>
                                              <option>Zemmouri</option>
                                              <option>Zouitina</option>
                                              <option>Al Amal</option>
                                              <option>Al Mandar Al Jamil</option>
                                              <option>Alia</option>
                                              <option>Benkirane</option>
                                              <option>Charf</option>
                                              <option>Draoua</option>
                                              <option>Drissia</option>
                                              <option>El Majd</option>
                                              <option>El Oued</option>
                                              <option>Mghogha</option>
                                              <option>Nzaha</option>
                                              <option>Sania</option>
                                              <option>Tanger City Center</option>
                                              <option>Tanja Balia</option>
                                              <option>Zone Industrielle Mghogha</option>
                                              <option>Azib Haj Kaddour</option>
                                              <option>Bel Air - Val fleuri</option>
                                              <option>Bir Chairi</option>
                                              <option>Branes 1</option>
                                              <option>Branes 2</option>
                                              <option>Casabarata</option>
                                              <option>Castilla</option>
                                              <option>Hay Al Bassatine</option>
                                              <option>Hay El Boughaz</option>
                                              <option>Hay Zaoudia</option>
                                              <option>Lalla Chafia</option>
                                              <option>Souani</option>
                                              <option>Achakar</option>
                                              <option>Administratif</option>
                                              <option>Ahammar</option>
                                              <option>Ain El Hayani</option>
                                              <option>Algerie</option>
                                              <option>Branes Kdima</option>
                                              <option>Californie</option>
                                              <option>Centre</option>
                                              <option>De La Plage</option>
                                              <option>Du Golf</option>
                                              <option>Hay Hassani</option>
                                              <option>Iberie</option>
                                              <option>Jbel Kbir</option>
                                              <option>Laaouina</option>
                                              <option>Marchan</option>
                                              <option>Mediouna</option>
                                              <option>Mesnana</option>
                                              <option>Mghayer</option>
                                              <option>Mister Khouch</option>
                                              <option>Mozart</option>
                                              <option>Msala</option>
                                              <option>M??dina</option>
                                              <option>Port Tanger ville</option>
                                              <option>Rmilat</option>
                                              <option>Star Hill</option>
                                              <option>manar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-danger">Ajouter</button>

                                    </div>
                                </div>
                            </form>
                            @if ($errors->any())
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>
                                        <strong>{{$error}}</strong>
                                        </li>
                                    @endforeach
                                </ul>
                              </div>
                              @endif
                        </div>

                      </div>
                    </div>
    </div>
    @endcan
</div>



@can('ecom')
<div class="container my-4">

  <div class="modal fade" id="modalSubscriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Nouvelle Commande</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body mx-3">
                          <form class="form-horizontal form-material" method="POST" action="{{route('commandes.store')}}">
                              @csrf

                              <div id="education_fields">

                              </div>
                                <div class="row" id="test">

                                    <div class="form-group col-md-6">
                                      <label for="produit" class="col-sm-12">Produit :</label>
                                      <div class="col-md-12">
                                          <select name="produit[]" id="produit" class="form-control form-control-line" value="{{ old('produit') }}" required>
                                              <option value="" disabled selected>Produit</option>
                                              @foreach ($produits as $produit)
                                          <option value="{{$produit->id}}" class="rounded-circle">
                                            {{$produit->libelle  .' '.$produit->reference}}
                                        </option>
                                              @endforeach

                                          </select>
                                        </div>
                                      </div>

                                      <div class="form-group col-md-4 input-group">
                                        <label for="qte" class="col-md-12">Quantit??:</label>
                                        <div class="col-md-12">
                                            <input  value="{{ old('qte') }}" type="number" class="form-control form-control-line" name="qte[]" id="qte" required>
                                        </div>

                                    </div>

                                </div>
                                <div class="input-group-btn col-md-2" style="position: relative; left:350px; top:-55px">
                                  <button class="btn btn-success " type="button"  onclick="education_fields();"> <span class="mdi mdi-library-plus" aria-hidden="true"></span> </button>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-12">Numero de la commande :</label>
                                  <div class="col-md-12">
                                      <input  value="{{ old('numero') }}" name="num" type="text" placeholder="Numero de la commande (Optionnel)" class="form-control form-control-line">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-12">Nom et Pr??nom du destinataire :</label>
                                  <div class="col-md-12">
                                      <input  value="{{ old('nom') }}" name="nom" type="text" placeholder="Nom & Pr??nom" class="form-control form-control-line" required>
                                  </div>
                              </div>

                              <div class="row form-group ">
                                  <div class="form-group col-md-4">
                                      <label for="qte" class="col-md-12">Nombre de Colis :</label>
                                      <div class="col-md-12">
                                          <input  value="{{ old('colis') }}" type="number" class="form-control form-control-line" name="colis" id="qte" required>
                                      </div>
                                  </div>


                                  <fieldset class="form-group col-md-4">
                                      <div class="row">
                                        <legend class="col-form-label  pt-0">Poids :</legend>
                                        <div class="col-sm-12">
                                          <div class="form-check">
                                            <input   class="form-check-input" type="radio" name="poids" id="normal" value="normal" checked>
                                            <label class="form-check-label" for="normal">
                                              P. Normal
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input   class="form-check-input" type="radio" name="poids" id="voluminaux" value="voluminaux">
                                            <label class="form-check-label" for="voluminaux">
                                              P. Volumineux
                                            </label>
                                          </div>

                                        </div>
                                      </div>
                                    </fieldset>

                                    <fieldset class="form-group col-md-4">
                                      <div class="row">
                                        <legend class="col-form-label  pt-0">Mode de paiement :</legend>
                                        <div class="col-sm-12">
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mode" id="cd" value="cd" checked>
                                            <label class="form-check-label" for="cd">
                                              Cash on delivery
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input  class="form-check-input" type="radio" name="mode" id="cp" value="cp">
                                            <label class="form-check-label" for="cp">
                                              Card payment
                                            </label>
                                          </div>

                                        </div>
                                      </div>
                                    </fieldset>



                              </div>

                              <div class="form-group">
                                  <label class="col-md-12">T??l??phone :</label>
                                  <div class="col-md-12">
                                      <input value="{{ old('telephone') }}"  name="telephone" type="text" placeholder="0xxx xxxxxx" class="form-control form-control-line" required>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-12">Adresse :</label>
                                  <div class="col-md-12">
                                      <textarea  name="adresse" rows="5" class="form-control form-control-line">{{ old('adresse') }}</textarea required>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-12">Ville :</label>
                                  <div class="col-sm-12">
                                      <select value="{{ old('ville') }}" name="ville" class="form-control form-control-line" id="ville" onchange="myFunction()" required>
                                          <option checked>Choisissez la ville</option>
                                          <option value="Tanger">Tanger</option>
                                          <option >Marrakech</option>
                                          <option >K??nitra</option>
                                          <option >Casablanca</option>
                                          <option >Rabat</option>
                                      </select>
                                  </div>
                              </div>
                              <div style="display: none"  class="form-group" id="secteur">
                                  <label class="col-sm-12">Secteur :</label>
                                  <div class="col-sm-12">
                                    <select  value="{{ old('secteur') }}" name="secteur" class="form-control form-control-line" required>

                                        <option value="">Tous les secteurs</option>
                                            <option>Aviation</option>
                                            <option>Al Kasaba</option>
                                            <option>Cap spartel</option>
                                            <option>Centre ville</option>
                                            <option>Cit?? californie</option>
                                            <option>Girari</option>
                                            <option>Ibn Taymia</option>
                                            <option>M'nar</option>
                                            <option>M'sallah</option>
                                            <option>Makhoukha</option>
                                            <option>Malabata</option>
                                            <option>Marchane</option>
                                            <option>Marjane</option>
                                            <option>Moujahidine</option>
                                            <option>Moulay Youssef</option>
                                            <option>Santa</option>
                                            <option>Val Fleuri</option>
                                            <option>Vieille montagne</option>
                                            <option>Ziatene</option>
                                            <option>Autre secteur</option>
                                            <option>Achennad</option>
                                            <option>Aharrarine</option>
                                            <option>Ahlane</option>
                                            <option>Aida</option>
                                            <option>Al Anbar</option>
                                            <option>Al Warda</option>
                                            <option>Aouama Gharbia</option>
                                            <option>Beausejour</option>
                                            <option>Behair</option>
                                            <option>Ben Dibane</option>
                                            <option>Beni Makada Lakdima</option>
                                            <option>Beni Said</option>
                                            <option>Beni Touzine</option>
                                            <option>Bir Aharchoune</option>
                                            <option>Bir Chifa</option>
                                            <option>Bir El Ghazi</option>
                                            <option>Bouchta-Abdelatif</option>
                                            <option>Bouhout 1</option>
                                            <option>Bouhout 2</option>
                                            <option>Dher Ahjjam</option>
                                            <option>Dher Lahmam</option>
                                            <option>El Baraka</option>
                                            <option>El Haj El Mokhtar</option>
                                            <option>El Khair 1</option>
                                            <option>El Khair 2</option>
                                            <option>El Mers 1</option>
                                            <option>El Mers 2</option>
                                            <option>El Mrabet</option>
                                            <option>Ennasr</option>
                                            <option>Gourziana</option>
                                            <option>Haddad</option>
                                            <option>Hanaa 1</option>
                                            <option>Hanaa 2</option>
                                            <option>Hanaa 3 - Soussi</option>
                                            <option>Jirrari</option>
                                            <option>Les Rosiers</option>
                                            <option>Zemmouri</option>
                                            <option>Zouitina</option>
                                            <option>Al Amal</option>
                                            <option>Al Mandar Al Jamil</option>
                                            <option>Alia</option>
                                            <option>Benkirane</option>
                                            <option>Charf</option>
                                            <option>Draoua</option>
                                            <option>Drissia</option>
                                            <option>El Majd</option>
                                            <option>El Oued</option>
                                            <option>Mghogha</option>
                                            <option>Nzaha</option>
                                            <option>Sania</option>
                                            <option>Tanger City Center</option>
                                            <option>Tanja Balia</option>
                                            <option>Zone Industrielle Mghogha</option>
                                            <option>Azib Haj Kaddour</option>
                                            <option>Bel Air - Val fleuri</option>
                                            <option>Bir Chairi</option>
                                            <option>Branes 1</option>
                                            <option>Branes 2</option>
                                            <option>Casabarata</option>
                                            <option>Castilla</option>
                                            <option>Hay Al Bassatine</option>
                                            <option>Hay El Boughaz</option>
                                            <option>Hay Zaoudia</option>
                                            <option>Lalla Chafia</option>
                                            <option>Souani</option>
                                            <option>Achakar</option>
                                            <option>Administratif</option>
                                            <option>Ahammar</option>
                                            <option>Ain El Hayani</option>
                                            <option>Algerie</option>
                                            <option>Branes Kdima</option>
                                            <option>Californie</option>
                                            <option>Centre</option>
                                            <option>De La Plage</option>
                                            <option>Du Golf</option>
                                            <option>Hay Hassani</option>
                                            <option>Iberie</option>
                                            <option>Jbel Kbir</option>
                                            <option>Laaouina</option>
                                            <option>Marchan</option>
                                            <option>Mediouna</option>
                                            <option>Mesnana</option>
                                            <option>Mghayer</option>
                                            <option>Mister Khouch</option>
                                            <option>Mozart</option>
                                            <option>Msala</option>
                                            <option>M??dina</option>
                                            <option>Port Tanger ville</option>
                                            <option>Rmilat</option>
                                            <option>Star Hill</option>
                                            <option>manar</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <div class="modal-footer d-flex justify-content-center">
                                      <button class="btn btn-danger">Ajouter</button>

                                  </div>
                              </div>
                          </form>
                          @if ($errors->any())
                          <div class="alert alert-dismissible alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>
                                      <strong>{{$error}}</strong>
                                      </li>
                                  @endforeach
                              </ul>
                            </div>
                            @endif
                      </div>

                    </div>
                  </div>
  </div>

</div>
@endcan





@endsection

@section('javascript')

    @if ($errors->any())
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#modalSubscriptionForm').modal('show');
            });
        </script>
    @endif


<script>
    var room = 1;
    function education_fields() {

        room++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "row removeclass"+room);
        var rdiv = 'removeclass'+room;

        divtest.innerHTML  = $("#test").html() + '<div class="input-group-btn"> <button class="btn btn-danger m-t-25" type="button" onclick="remove_education_fields('+ room +');"> <span class="mdi mdi-close-box" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div>';

        objTo.appendChild(divtest)
    }
    function remove_education_fields(rid) {
        $('.removeclass'+rid).remove();
    }

</script>
<script>

    function checkFunction(){

        var cbp = document.getElementById('check_bl');
        if (cbp.checked == true){
            var cbs = document.querySelectorAll('.cb');
            cbs.forEach((cb) => {
                cb.checked = true;
            });
        } else {
            var cbs = document.querySelectorAll('.cb');
            cbs.forEach((cb) => {
                cb.checked = false;
            });
        }
        }

    </script>

        <!-- plugins:js -->
        <script src="{{ url('vendor/js/vendor.bundle.base.js') }}"></script>
        <script src="{{ url('vendor/js/vendor.bundle.addons.js') }}"></script>
        <!-- endinject -->
        <script src="{{ url('js/data-table.js') }}"></script>


@endsection
