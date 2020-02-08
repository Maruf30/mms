<style type="text/css">
	table tr > th, table tr > td {
		border: 1px solid #000000;
	}
	.lightgray {
		background-color: #C0C0C0;
	}
</style>
<table>
	<thead>
		<tr>
			<th colspan="4" align="center" {{-- style="font-size: 30px;" --}}>Transaction Summary: Staff wise total Collection and Disbursement</th>
		</tr>
		<tr>
			<th colspan="4" align="left">Date: {{ date('D, d/m/Y') }}</th>
		</tr>
		<tr>
			<th class="lightgray">Loan Officer</th>
			<th class="lightgray" align="center">Total Collection</th>
			<th class="lightgray" align="center">Total Disbursement</th>
			<th class="lightgray" align="center">Rest Amount</th>
		</tr>
	</thead>
	<tbody>
		@php
			$totalloaninstallmentscollection = 0;
			$totalsavinginstallmentscollection = 0;
			$totalinsurance = 0;
			$totalprocessing_fee = 0;
			$totaladmission_fee = 0;
			$totalpassbook_fee = 0;
			$totalshared_deposit = 0;
		@endphp
		@foreach($staffs as $staff)
		<tr>
			<td align="left">{{ $staff->name }}</td>
			<td>
				@php
					// loaninstallments
					$staffloaninstallmentscollection = 0;
					foreach ($loaninstallments as $loaninstallment) {
						if($loaninstallment->user_id == $staff->id) {
							$staffloaninstallmentscollection = $staffloaninstallmentscollection + $loaninstallment->paid_total;
						}
					}
					$totalloaninstallmentscollection = $totalloaninstallmentscollection + $staffloaninstallmentscollection;

					// savinginstallments
					$staffsavinginstallmentscollection = 0;
					foreach ($savinginstallments as $savinginstallment) {
						if($savinginstallment->user_id == $staff->id) {
							$staffsavinginstallmentscollection = $staffsavinginstallmentscollection + $savinginstallment->amount;
						}
					}
					$totalsavinginstallmentscollection = $totalsavinginstallmentscollection + $staffsavinginstallmentscollection;

					// loan other payments
					$staffinsurance = 0;
					foreach ($totalloans as $loan) {
						if($loan->member->staff_id == $staff->id) {
							$staffinsurance = $staffinsurance + $loan->insurance;
						}
						$totalinsurance = $totalinsurance + $staffinsurance;
					}

					$staffprocessing_fee = 0;
					foreach ($totalloans as $loan) {
						if($loan->member->staff_id == $staff->id) {
							$staffprocessing_fee = $staffprocessing_fee + $loan->processing_fee;
						}
						$totalprocessing_fee = $totalprocessing_fee + $staffprocessing_fee;
					}

					// member other payments
					$staffadmission_fee = 0;
					foreach ($totalmembers as $member) {
						if($member->staff_id == $staff->id) {
							$staffadmission_fee = $staffadmission_fee + $member->admission_fee;
						}
						$totaladmission_fee = $totaladmission_fee + $staffadmission_fee;
					}

					$staffpassbook_fee = 0;
					foreach ($totalmembers as $member) {
						if($member->staff_id == $staff->id) {
							$staffpassbook_fee = $staffpassbook_fee + $member->passbook_fee;
						}
						$totalpassbook_fee = $totalpassbook_fee + $staffpassbook_fee;
					}

					$staffshared_deposit = 0;
					foreach ($totalmembers as $member) {
						if($member->staff_id == $staff->id) {
							$staffshared_deposit = $staffshared_deposit + $member->shared_deposit;
						}
						$totalshared_deposit = $totalshared_deposit + $staffshared_deposit;
					}
				@endphp
				{{ $staffshared_deposit }} 
				{{ $staffloaninstallmentscollection + $staffsavinginstallmentscollection + $staffinsurance + $staffprocessing_fee + $staffadmission_fee + $staffpassbook_fee + $staffshared_deposit}}
			</td>
			<td>
				
			</td>
			<td>
				
			</td>
		</tr>
		@endforeach
		<tr>
			<td align="left">Total</td>
			<td>
				{{ $totalshared_deposit }} 
				{{ $totalloaninstallmentscollection + $totalsavinginstallmentscollection + $totalinsurance + $totalprocessing_fee  + $totaladmission_fee + $totalpassbook_fee + $totalshared_deposit }}
			</td>
			<td>
				
			</td>
			<td>
				
			</td>
		</tr>
	</tbody>
</table>