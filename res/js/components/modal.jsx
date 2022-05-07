
import { Button , ButtonToolbar ,Popover ,Tooltip , Modal , OverlayTrigger} from 'react-bootstrap';

class App extends React.Component {
    
        constructor(props) {
                super(props);
                this.state = {  showModal: false
                     };
  }
    close() {
//    this.setState({ showModal: false });
    this.state.showmodal = false;
  }

  open() {
    this.state.showmodal = true;
  }

   render() {
      return (
         <div>

        <a href="#" className="icon-btn" role="button"  onClick={this.open}>
                        <i className="fa fa-table"></i>
                        <div> Table </div>
                    </a>
         

        <Modal show={true} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title>Modal heading</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <h4>Text in a modal</h4>
            <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>


            <hr />

            <h4>Overflowing text to show scroll behavior</h4>
          </Modal.Body>
          <Modal.Footer>
            <Button onClick={this.close}>Close</Button>
          </Modal.Footer>
        </Modal>
      </div>
      );
   }
}

class Header extends React.Component {
   render() {
      return (
         <div>
            <h1>Header</h1>
         </div>
      );
   }
}

class Content extends React.Component {
   render() {
      return (
         <div>
            <h2>Content</h2>
            <p>The content text!!!</p>
         </div>
      );
   }
}

export default App;