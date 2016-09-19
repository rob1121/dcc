<?php

use App\CustomerSpec;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class AddExternalSpecTest extends TestCase
{
//    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;
//
//    /** @test */
//    public function it_can_spec()
//    {
//        $this->factory = new CustomerSpecFactory;
//    }
//}
//
//class CustomerSpecFactory {
//    private $rel;
//    private $request;
//
//    public function __construct($request, $rel = null)
//    {
//
//        $this->request = $request;
//        $this->rel = $rel;
//    }
//    public function create($spec)
//    {
//        switch($spec) {
//            case "customer" : new CreateCustomerSpec($this->request); break;
//            case "customer revision" : new CreateCustomerSpecRevision($this->rel, $this->request); break;
//            case "customer category" : new CreateCustomerSpecCategory($this->rel, $this->request); break;
//        }
//    }
//}
//
//interface CustomerInterface {
//    public function add();
//}
//
//class CreateCustomerSpec implements CustomerInterface {
//
//    private $request;
//
//    public function __construct(Request $request)
//    {
//        $this->request = $request;
//    }
//
//    public function add()
//    {
//        arrayWithSize()
//    }
//}
//
//class CreateCustomerSpecRevision implements CustomerInterface {
//    private $request;
//    private $rel;
//
//    public function __construct(Request $request, CustomerSpec $rel)
//    {
//        $this->request = $request;
//        $this->rel = $rel;
//    }
//
//    public function add()
//    {
//        // TODO: Implement add() method.
//    }
//}
//
//class CreateCustomerSpecCategory implements CustomerInterface {
//    private $request;
//    private $rel;
//
//    public function __construct(Request $request, CustomerSpec $rel)
//    {
//        $this->request = $request;
//        $this->rel = $rel;
//    }
//
//    public function create()
//    {
//
//    }
//
//
//    public function add()
//    {
//        // TODO: Implement add() method.
//    }
}
