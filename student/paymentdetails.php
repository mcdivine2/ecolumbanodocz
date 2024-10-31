<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Payment Details Form -->
        <form id="paymentForm">
          <div class="form-group">
            <label for="referenceNo">Reference No.</label>
            <input type="text" class="form-control" id="referenceNo" value="ref_<?= uniqid(); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="studentName">Student Name</label>
            <input type="text" class="form-control" id="studentName" value="student name" readonly>
          </div>
          <div class="form-group">
            <label for="controlNo">Control No.</label>
            <input type="text" class="form-control" id="controlNo" placeholder="Enter control number">
          </div>
          <div class="form-group">
            <label for="documentName">Document Name</label>
            <input type="text" class="form-control" id="documentName" value="List of the documents" readonly>
          </div>
          <div class="form-group">
            <label for="totalAmount">Total Amount</label>
            <input type="text" class="form-control" id="totalAmount" placeholder="Total amount to be paid">
          </div>
          <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
      </div>
    </div>
  </div>
</div>
  


